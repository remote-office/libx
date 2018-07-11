<?php

  namespace LibX\Util;
  
  use InvalidArgumentException;
  
  /**
   * Date
   *
   * Class for handling date formats, uses ISO 8601 as format
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Date
  {
    /**
     * Seperators (-) are optional
     * Year: Optinal minus, 4 or 2 digits (-0020, 2007, 07)
     * Month: 2 digits (01, 12)
     * Day: 2 digits (01, 30)
     */
    const PATTERN = '-?(\d{4}|\d{2})-?(\d{2})-?(\d{2})';
    const NOW = 1;
    
    protected $year;
    protected $month;
    protected $day;
    
    /**
     * Construct a new Date
     *
     * @param string $date
     * @return Date
     */
    public function __construct($date = self::NOW)
    {
      if($date === self::NOW)
        $date = date('Y-m-d');
        
      // Do regex
      $matches = self::regex($date);
        
      // Extract matches
      list($original, $year, $month, $day) = $matches;
      
      // Initialize class variables
      $this->setDate($year, $month, $day);
    }
    
    /**
     * Get the value of this Date as an ISO string
     *
     * @param void
     * @return string
     */
    public function getValue()
    {
      $value = sprintf("%04d-%02d-%02d", $this->year, $this->month, $this->day);
      
      return $value;
    }
    
    /**
     * Get the value of this Date as a locale string
     *
     * @param void
     * @return string
     */
    public function getLocale()
    {
      $value = sprintf("%02d-%02d-%04d", $this->day, $this->month, $this->year);
      
      return $value;
    }
    
    /**
     * Set the date represented by this Date
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @return void
     */
    public function setDate($year, $month, $day)
    {
      // Validate
      self::validateDate($year, $month, $day);
      
      // Set internal year, month and day variables
      $this->year  = (int)$year;
      $this->month = (int)$month;
      $this->day   = (int)$day;
    }
    
    public function getYear()
    {
      return $this->year;
    }
    
    public function getMonth()
    {
      return $this->month;
    }
    
    public function getDay()
    {
      return $this->day;
    }
    
    /**
     * Validate if a string is a date
     *
     * @param string $date
     * @return boolean true if string is a date, false otherwise
     */
    static public function validate($date)
    {
      // Check if date is a string
      if(is_string($date) && strlen(trim($date)) > 0)
        return false;
        
      // Check if date matches pattern
      if(!preg_match('/^' . self::PATTERN . '$/', $date, $matches))
        return false;
          
      // Extract values from date
      list($original, $year, $month, $day) = $matches;
          
      // Check if all values are valid
      if(!self::validateDate($year, $month, $day))
        return false;
            
      return true;
    }
    
    /**
     * Match agains pattern
     *
     * @param string $date
     * @return array
     */
    static protected function regex($date)
    {
      if(!preg_match('/^' . self::PATTERN . '$/', $date, $matches))
        throw new InvalidArgumentException(__METHOD__ . '; Invalid date, no match with pattern (' . $date . ')');
        
      return $matches;
    }
    
    /**
     * Validate a date (intern)
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @return boolean true if date is valid, false otherwise
     */
    static protected function validateDate($year, $month, $day)
    {
      return true;
    }
  }

?>