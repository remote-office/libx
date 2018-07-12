<?php

  namespace LibX\SimplePay\Response;
  
  use LibX\SimplePay\Response;
  use LibX\SimplePay\Authenticator;
  
  use LibX\Util\Uuid;

  /**
   * TransactionResponse
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class TransactionResponse extends Response
  {
    protected $transaction;
    protected $redirect;
    
    /**
     * Construct a new TransactionResponse
     *
     * @param Uuid $transaction
     * @param Authenticator $authenticator
     * @return TransactionResponse
     */
    public function __construct(Uuid $transaction, Authenticator $authenticator)
    {
      $this->setTransaction($transaction);
      $this->setAuthenticator($authenticator);
    }
    
    /**
     * Get transaction of this TransactionResponse
     *
     * @param void
     * @return Uuid
     */
    public function getTransaction()
    {
      return $this->transaction;
    }
    
    /**
     * Set transaction of this TransactionResponse
     *
     * @param Uuid $transaction
     * @return void
     */
    public function setTransaction(Uuid $transaction)
    {
      $this->transaction = $transaction;
    }
    
    /**
     * Get authenticator of this TransactionResponse
     *
     * @param void
     * @return Authenticator
     */
    public function getAuthenticator()
    {
      return $this->authenticator;
    }
    
    /**
     * Set authenticator of this TransactionResponse
     *
     * @param Authenticator $authenticator
     * @return void
     */
    public function setAuthenticator($authenticator)
    {
      $this->authenticator = $authenticator;
    }
  }

?>