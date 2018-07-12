<?php

  namespace LibX\SimplePay\Request;
  
  use LibX\SimplePay\Request;
  use LibX\SimplePay\User;
  
  use LibX\Util\Uuid;
  
  /**
   * StatusRequest
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class StatusRequest extends Request
  {
    protected $transaction;
    
    /**
     * Construct a new StatusRequest
     *
     * @param User $user
     * @param Uuid $transaction
     * @return StatusRequest
     */
    public function __construct(User $user, Uuid $transaction)
    {
      $this->setUser($user);
      $this->setTransaction($transaction);
    }
    
    /**
     * Get transaction uuid of this StatusRequest
     *
     * @param void
     * @return Uuid
     */
    public function getTransaction()
    {
      return $this->transaction;
    }
    
    /**
     * Set transaction uuid of this StatusRequest
     *
     * @param Uuid $transaction
     * @return void
     */
    public function setTransaction(Uuid $transaction)
    {
      $this->transaction = $transaction;
    }
  }

?>