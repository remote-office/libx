<?php

  namespace LibX\SimplePay\Account;
  
  use LibX\SimplePay\Account;
  use LibX\Util\Uuid;
  
  /**
   * PrepaidAccount
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class PrepaidAccount extends Account
  {
    protected $uuid;
    
    /**
     * Construct a PrepaidAccount
     *
     * @param Uuid $uuid
     * @return PrepaidAccount
     */
    public function __construct(Uuid $uuid)
    {
      $this->setUuid($uuid);
    }
    
    /**
     * Get uuid of this PrepaidAccount
     *
     * @param void
     * @return Uuid
     */
    public function getUuid()
    {
      return $this->uuid;
    }
    
    /**
     * Set uuid of this PrepaidAccount
     *
     * @param Uuid $uuid
     * @return void
     */
    public function setUuid(Uuid $uuid)
    {
      $this->uuid = $uuid;
    }
  }
  
?>