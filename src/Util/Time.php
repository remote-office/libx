<?php

  namespace LibX\Util;
  
  use InvalidArgumentException;
  
  /**
   * Time
   *
   * Class for handling time formats, uses ISO 8601 as format
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Time
  {
    /**
     * Seperators (:) are optional
     * Hours: 2 digits
     * Minutes: 2 digits
     * Seconds: Optional 2 digits
     * Microtime: Optional (only when seconds is also present) one or more digits
     */
    const PATTERN = '(\d{2}):?(\d{2})(?::?(\d{2})(\.\d+(Z)?)?)';
    const NOW = 1;
    
    protected $hours;
    protected $minutes;
    protected $seconds;
    protected $microtime;
    
    /**
     * Construct a new Time
     *
     * @param string $time
     * @return Time
     */
    public function __construct($time = self::NOW)
    {
      if($time === self::NOW)
        $time = date('H:i:s');
        
      // Do regex
      $matches = self::regex($time);
        
      // Extract matches
      if(count($matches) == 5)
        list($original, $hours, $minutes, $seconds, $microtime) = $matches;
      else
        list($original, $hours, $minutes, $seconds) = $matches;
            
      // If microtime is set at it to seconds
      if(isset($microtime))
        $seconds += $microtime;
              
      // Initialize class variables
      $this->setTime($hours, $minutes, $seconds);
    }
    
    /**
     * Get the value of this Time as an ISO string
     *
     * @param void
     * @return string
     */
    public function getValue()
    {
      $value = sprintf("%02d:%02d", $this->hours, $this->minutes);
      
      if(isset($this->seconds))
        $value .= sprintf(":%02d", $this->seconds);
        
      if(isset($this->microtime))
        $value .= substr($this->microtime, 1);
          
      return $value;
    }
    
    /**
     * Set the time represented by this Time
     *
     * @param integer $hours
     * @param integer $minutes
     * @param integer $seconds
     * @return void
     */
    public function setTime($hours, $minutes, $seconds)
    {
      // Validate
      self::validateTime($hours, $minutes, $seconds);
      
      // Set internal hours, minutes, seconds and microtime variables
      $this->hours   = (int)$hours;
      $this->minutes = (int)$minutes;
      $this->seconds = (int)$seconds;
      
      if(is_float($seconds))
        $this->microtime = fmod($seconds, floor($seconds));
    }
    
    /**
     * Validate if a string is a time
     *
     * @param string $time
     * @return boolean true if string is a time, false otherwise
     */
    static public function validate($time)
    {
      // Check if date is a string
      if(is_string($time) && strlen(trim($time)) > 0)
        return false;
        
      // Check if date matches pattern
      if(!preg_match('/^' . self::PATTERN . '$/', $time, $matches))
        return false;
          
      // Extract values from time
      if(count($matches) == 5)
        list($original, $hours, $minutes, $seconds, $microtime) = $matches;
      else
        list($original, $hours, $minutes, $seconds) = $matches;
              
      // If microtime is set at it to seconds
      if(isset($microtime))
        $seconds += $microtime;
                
      // Check if all values are valid
      if(!self::validateTime($hours, $minutes, $seconds))
        return false;
                  
      return true;
    }
    
    /**
     * Match agains pattern
     *
     * @param string $time
     * @return array
     */
    static protected function regex($time)
    {
      if(!preg_match('/^' . self::PATTERN . '$/', $time, $matches))
        throw new InvalidArgumentException(__METHOD__ . '; Invalid time, no match with pattern (' . $time . ')');
        
      return $matches;
    }
    
    /**
     * Validate a time (intern)
     *
     * @param integer $hours
     * @param integer $minutes
     * @param integer $seconds
     * @return boolean true if time is valid, false otherwise
     */
    static protected function validateTime($hours, $minutes, $seconds)
    {
      return true;
    }
  }
  
  /**
   * TimeWithTimezone
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class TimeWithTimezone extends Time
  {
    /**
     * Seperators (:) are optional
     * Hours: 2 digits
     * Minutes: 2 digits
     * Seconds: Optional 2 digits
     * Microtime: Optional (only when seconds is also present) one or more digits
     *
     * Timezone sign: Z for zulutime, + or - for timezone
     * Timezone hours: Optional (only if timezone sign + or - is present) 2 digits
     * Timezone minutes: Optional (only if timezone hours is present) 2 digits
     */
    const PATTERN = '(\d{2}):?(\d{2})(?::?(\d{2})(\.\d+)?)?(?:(?:(Z)|([+-])(\d{2})(?::?(\d{2}))?))';
    
    protected $timezone;
    
    /**
     * Construct a new TimeWithTimezone
     *
     * @param string $time
     * @return TimeWithTimezone
     */
    public function __construct($time = self::NOW)
    {
      
    }
    
    /**
     * Get the value of this TimeWithTimezone as an ISO string
     *
     * @param void
     * @return string
     */
    public function getValue()
    {
    }
    
    /**
     * Validate if a string is a time with timezone
     *
     * @param string $time
     * @return boolean true if string is a time with timezone, false otherwise
     */
    static public function validate($time)
    {
      
    }
  }

?>