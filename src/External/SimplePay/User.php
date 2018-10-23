<?php

  namespace LibX\External\SimplePay;

  use InvalidArgumentException;

  use LibX\Util\Uuid;

  /**
   * User
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class User
  {
    protected $uuid;
    protected $hash;

    /**
     * Construct a new User
     *
     * @param Uuid $uuid
     * @param string $hash
     * @return User
     */
    public function __construct(Uuid $uuid, $hash)
    {
      $this->setUuid($uuid);
      $this->setHash($hash);
    }

    /**
     * Get uuid of this User
     *
     * @param void
     * @return Uuid
     */
    public function getUuid()
    {
      return $this->uuid;
    }

    /**
     * Set uuid of this User
     *
     * @param Uuid $uuid
     * @return void
     */
    public function setUuid(Uuid $uuid)
    {
      $this->uuid = $uuid;
    }

    /**
     * Get hash of this User
     *
     * @param void
     * @return string
     */
    public function getHash()
    {
      return $this->hash;
    }

    /**
     * Set hash of this User
     *
     * @param string $hash
     * @return void
     */
    public function setHash($hash)
    {
      if(!is_string($hash) || strlen(trim($hash)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid hash, must be a non empty string');

      $this->hash = $hash;
    }
  }

?>