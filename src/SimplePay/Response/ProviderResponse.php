<?php

  namespace LibX\SimplePay\Response;
  
  use LibX\SimplePay\Response;
  use LibX\SimplePay\Provider;
  use LibX\SimplePay\ProviderStack;
  
  /**
   * ProviderResponse
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class ProviderResponse extends Response
  {
    protected $providerStack;
    
    /**
     * Construct a new ProviderResponse
     *
     * @param void
     * @return ProviderResponse
     */
    public function __construct()
    {
      $this->providerStack = new ProviderStack();
    }
    
    /**
     * Add a bank to the webservice ideal bank stack
     *
     * @param Provider $provider
     * @return void
     */
    public function addProvider(Provider $provider)
    {
      $this->providerStack->push($provider);
    }
    
    /**
     * Get the provider stack of this ProviderResponse
     *
     * @param void
     * @return ProviderStack
     */
    public function getProviderStack()
    {
      return $this->providerStack;
    }
    
    /**
     * Set the provider stack of this ProviderResponse
     *
     * @param ProviderStack $providerStack
     * @return void
     */
    public function setProviderStack(ProviderStack $providerStack)
    {
      $this->providerStack = $providerStack;
    }
  }

?>