<?php

  namespace LibX\SimplePay;
  
  use InvalidArgumentException;
  
  /**
   * Payment
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Payment
  {
    // Currency
    const CURRENCY_EURO    = 'EUR';
    const CURRENCY_DOLLAR  = 'USD';
    
    protected $reference;
    protected $amount;
    protected $currency;
    protected $description;
    protected $account;
    
    /**
     * Construct a new Payment
     *
     * @param string $reference
     * @param integer $amount
     * @param string $curreny
     * @param string $description
     * @param Account $account
     * @return Payment
     */
    public function __construct($reference, $amount, $currency, $description = null, Account $account = null)
    {
      $this->setReference($reference);
      $this->setAmount($amount);
      $this->setCurrency($currency);
      
      if(!is_null($description))
        $this->setDescription($description);
        
      if(!is_null($account))
        $this->setAccount($account);
    }
    
    /**
     * Get reference of this Payment
     *
     * @param void
     * @return string
     */
    public function getReference()
    {
      return $this->reference;
    }
    
    /**
     * Set reference of this Payment
     *
     * @param string $reference
     * @return void
     */
    public function setReference($reference)
    {
      if(!is_string($reference) || strlen(trim($reference)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid reference, must be a non empty string');
        
      $this->reference = $reference;
    }
    
    /**
     * Get amount of this Payment
     *
     * @param void
     * @return integer
     */
    public function getAmount()
    {
      return $this->amount;
    }
    
    /**
     * Set amount of this Payment
     *
     * @param integer $amount
     * @return void
     */
    public function setAmount($amount)
    {
      if(!is_int($amount) || $amount < 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid amount, must be a positive integer');
        
      $this->amount = $amount;
    }
    
    /**
     * Get currency of this Payment
     *
     * @param void
     * @return string
     */
    public function getCurrency()
    {
      return $this->currency;
    }
    
    /**
     * Set currency of this Payment
     *
     * @param string $currency
     * @return void
     */
    public function setCurrency($currency)
    {
      if(!is_string($currency) || strlen(trim($currency)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid currency, must be a non empty string');
        
      $this->currency = $currency;
    }
    
    /**
     * Check if this Payment has a description
     *
     * @param void
     * @return boolean
     */
    public function hasDescription()
    {
      return !is_null($this->description);
    }
    
    /**
     * Get description of this Payment
     *
     * @param void
     * @return string
     */
    public function getDescription()
    {
      return $this->description;
    }
    
    /**
     * Set description of this Payment
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
      if(!is_string($description) || strlen(trim($description)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid description, must be a non empty string');
        
      $this->description = $description;
    }
    
    /**
     * Check if this Payment has an account
     *
     * @param void
     * @return boolean
     */
    public function hasAccount()
    {
      return !is_null($this->account);
    }
    
    /**
     * Get account of this Payment
     *
     * @param void
     * @return Account
     */
    public function getAccount()
    {
      return $this->account;
    }
    
    /**
     * Set account of this Payment
     *
     * @param Account $account
     * @return void
     */
    public function setAccount(Account $account)
    {
      $this->account = $account;
    }
  }

?>
