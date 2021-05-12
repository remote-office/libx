<?php

  namespace LibX\SimplePay;
  
  /**
   * Callback
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Callback
  {
    protected $redirectUrl;
    protected $callbackUrl;
    
    /**
     * Construct a Callback
     *
     * @param string $redirectUrl
     * @param string $callbackUrl
     * @return Callback
     */
    public function __construct($redirectUrl, $callbackUrl)
    {
      $this->setRedirectUrl($redirectUrl);
      $this->setCallbackUrl($callbackUrl);
    }
    
    /**
     * Get the redirect url of this Callback
     *
     * @param void
     * @return string
     */
    public function getRedirectUrl()
    {
      return $this->redirectUrl;
    }
    
    /**
     * Set the redirect url of this Callback
     *
     * @param string $redirectUrl
     * @return void
     */
    public function setRedirectUrl($redirectUrl)
    {
      $this->redirectUrl = $redirectUrl;
    }
    
    /**
     * Get the callback url of this Callback
     *
     * @param void
     * @return string
     */
    public function getCallbackUrl()
    {
      return $this->callbackUrl;
    }
    
    /**
     * Set the callback url of this Callback
     *
     * @param string $callbackUrl
     * @return void
     */
    public function setCallbackUrl($callbackUrl)
    {
      $this->callbackUrl = $callbackUrl;
    }
  }

?>