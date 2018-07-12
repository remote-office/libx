<?php

  namespace LibX\SimplePay\Response;

  use LibX\SimplePay\Response;
  use LibX\SimplePay\Transaction;
  use LibX\SimplePay\Payment;
  
  /**
   * Status
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class StatusResponse extends Response
  {
    protected $transaction;
    protected $payment;
    
    /**
     * Construct a new StatusResponse
     *
     * @param Transaction $transaction
     * @param Payment $payment
     * @return StatusResponse
     */
    public function __construct(Transaction $transaction, Payment $payment)
    {
      $this->setTransaction($transaction);
      $this->setPayment($payment);
    }
    
    /**
     * Get transaction of this StatusResponse
     *
     * @param void
     * @return Transaction
     */
    public function getTransaction()
    {
      return $this->transaction;
    }
    
    /**
     * Set transaction of this StatusResponse
     *
     * @param Transaction $transaction
     * @return void
     */
    public function setTransaction(Transaction $transaction)
    {
      $this->transaction = $transaction;
    }
    
    /**
     * Get the payment of this StatusResponse
     *
     * @param void
     * @return Payment
     */
    public function getPayment()
    {
      return $this->payment;
    }
    
    /**
     * Set the payment of this StatusResponse
     *
     * @param Payment $payment
     * @return void
     */
    public function setPayment(Payment $payment)
    {
      $this->payment = $payment;
    }
  }

?>