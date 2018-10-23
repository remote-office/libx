<?php

  namespace LibX\External\SimplePay;

  use InvalidArgumentException;

  use LibX\Util\Uuid;

  /**
   * Authenticator
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Authenticator
  {
    protected $uuid;
    protected $name;
    protected $authenticationUrl;

    /**
     * Construct a new Authenticator
     *
     * @param Uuid $uuid
     * @param string $name
     * @param string $authenticationUrl
     * @return Authenticator
     */
    public function __construct(Uuid $uuid, $name, $authenticationUrl)
    {
      $this->setUuid($uuid);
      $this->setName($name);
      $this->setAuthenticationUrl($authenticationUrl);
    }

    /**
     * Get uuid of this Authenticator
     *
     * @param void
     * @return Uuid
     */
    public function getUuid()
    {
      return $this->uuid;
    }

    /**
     * Set uuid of this Authenticator
     *
     * @param Uuid $uuid
     * @return void
     */
    public function setUuid(Uuid $uuid)
    {
      $this->uuid = $uuid;
    }

    /**
     * Get name of this Authenticator
     *
     * @param void
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * Set name of this Authenticator
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
      if(!is_string($name) || strlen(trim($name)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid name, must be a non empty string');

      $this->name = $name;
    }

    /**
     * Get authentication url of this Authenticator
     *
     * @param void
     * @return string
     */
    public function getAuthenticationUrl()
    {
      return $this->authenticationUrl;
    }

    /**
     * Set authentication url of this Authenticator
     *
     * @param string $authenticationUrl
     * @return void
     */
    public function setAuthenticationUrl($authenticationUrl)
    {
      if(!is_string($authenticationUrl) || strlen(trim($authenticationUrl)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid authentication url, must be a non empty string');

      $this->authenticationUrl = $authenticationUrl;
    }
  }

?>