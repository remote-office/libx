<?php
  
  namespace LibX\SimplePay\Request;
  
  use LibX\SimplePay\Request;
  use LibX\SimplePay\User;
  use LibX\SimplePay\Payment;
  use LibX\SimplePay\Callback;
  
  use LibX\Util\Uuid;

  /**
   * TransactionRequest
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class TransactionRequest extends Request
  {
    protected $provider;
    protected $payment;
    protected $callback;
    
    /**
     * Construct a new TransactionRequest 
     *
     * @param User $user
     * @param Uuid $provider
     * @param Payment $payment
     * @param Callback $callback
     * @return TransactionRequest;
     */
    public function __construct(User $user, Uuid $provider, Payment $payment, Callback $callback)
    {
      $this->setUser($user);
      $this->setProvider($provider);
      $this->setPayment($payment);
      $this->setCallback($callback);
    }
    
    /**
     * Get the provider uuid of this TransactionRequest
     *
     * @param void
     * @return Uuid
     */
    public function getProvider()
    {
      return $this->provider;
    }
    
    /**
     * Set the provider uuid of this TransactionRequest
     *
     * @param Uuid $provider
     * @return void
     */
    public function setProvider(Uuid $provider)
    {
      $this->provider = $provider;
    }
    
    /**
     * Get the payment of this TransactionRequest
     *
     * @param void
     * @return Payment
     */
    public function getPayment()
    {
      return $this->payment;
    }
    
    /**
     * Set the payment of this TransactionRequest
     *
     * @param Payment $payment
     * @return void
     */
    public function setPayment(Payment $payment)
    {
      $this->payment = $payment;
    }
    
    /**
     * Get the callback of this TransactionRequest
     *
     * @param void
     * @return Callback
     */
    public function getCallback()
    {
      return $this->callback;
    }
    
    /**
     * Set the callback of this TransactionRequest
     *
     * @param Callback $callback
     * @return void
     */
    public function setCallback(Callback $callback)
    {
      $this->callback = $callback;
    }
  }

?>