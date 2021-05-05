<?php

  namespace LibX\Webservice;

  use Exception;
  use InvalidArgumentException;
  use SoapClient;
  
  /**
   * Client
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  abstract class Client
  {
    protected $wsdl;
    protected $client;
    
    /**
     * Construct a new Client
     *
     * @param string $wsdl
     * @return Client
     */
    public function __construct($wsdl = null)
    {
      if(!is_null($wsdl))
        $this->setWsdl($wsdl);
    }
    
    /**
     * Get the WSDL of this Client
     *
     * @param void
     * @return string
     */
    public function getWsdl()
    {
      return $this->wsdl;
    }
    
    /**
     * Set the WSDL of this Client
     *
     * @param string $wsdl
     * @return void
     */
    public function setWsdl($wsdl)
    {
      if (!is_string($wsdl) || strlen(trim($wsdl)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid wsdl given, must be a non empty string');
        
        $this->wsdl = $wsdl;
    }
    
    /**
     * Get instance of SoapClient for this Client
     *
     * @param void
     * @return SoapClient
     */
    protected function getSoapClient()
    {
      if(!isset($this->wsdl))
        throw new Exception(__METHOD__ .'; No WSDL set');
        
      if(!(is_null($this->client) && $this->client instanceof SoapClient))
        $this->client = new SoapClient($this->wsdl);
          
      return $this->client;
    }
  }

?>