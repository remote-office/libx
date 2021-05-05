<?php

  namespace LibX\External\SimplePay\Account;

  use LibX\External\SimplePay\Account;

  use InvalidArgumentException;

  /**
   * CreditCard
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class CreditCardAccount extends Account
  {
    protected $holder;
    protected $number;
    protected $experationDate;
    protected $code;

    /**
     * Construct a CreditCard
     *
     * @param string $holder
     * @param string $number
     * @param string $experationDate
     * @param string $code
     * @return CreditCardAccount
     */
    public function __construct($holder, $number, $experationDate, $code)
    {
      $this->setHolder($holder);
      $this->setNumber($number);
    }

    /**
     * Get the holder of this CreditCard
     *
     * @param void
     * @return string
     */
    public function getHolder()
    {
      return $this->holder;
    }

    /**
     * Set the holder of this CreditCard
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
     * Get the number of this CreditCard
     *
     * @param void
     * @return string
     */
    public function getNumber()
    {
      return $this->number;
    }

    /**
     * Set the number of this CreditCard
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
  }

?>