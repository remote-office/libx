<?php

  namespace LibX\SimplePay\Account;
  
  use LibX\SimplePay\Account;
  
  use InvalidArgumentException;
  
  /**
   * Incasso
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class IncassoAccount extends Account
  {
    protected $holder;
    protected $number;
    protected $city;
    
    /**
     * Construct a IncassoAccount
     *
     * @param string $holder
     * @param string $number
     * @param string $city
     * @return IncassoAccount
     */
    public function __construct($holder, $number, $city)
    {
      $this->setHolder($holder);
      $this->setNumber($number);
      $this->setCity($city);
    }
    
    /**
     * Get the holder of this IncassoAccount
     *
     * @param void
     * @return string
     */
    public function getHolder()
    {
      return $this->holder;
    }
    
    /**
     * Set the holder of this IncassoAccount
     *
     * @param string $holder
     * @return void
     */
    public function setHolder($holder)
    {
      if(!is_string($holder) || strlen(trim($holder)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid holder, must be a non empty string');
        
      $this->holder = $holder;
    }
    
    /**
     * Get the number of this IncassoAccount
     *
     * @param void
     * @return string
     */
    public function getNumber()
    {
      return $this->number;
    }
    
    /**
     * Set the number of this IncassoAccount
     *
     * @param string $number
     * @return void
     */
    public function setNumber($number)
    {
      if(!is_string($number) || strlen(trim($number)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid number, must be a non empty string');
        
      $this->number = $number;
    }
    
    /**
     * Get the city of this IncassoAccount
     *
     * @param void
     * @return string
     */
    public function getCity()
    {
      return $this->city;
    }
    
    /**
     * Set the city of this IncassoAccount
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
      if(!is_string($city) || strlen(trim($city)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid city, must be a non empty string');
        
      $this->city = $city;
    }
  }
  
?>