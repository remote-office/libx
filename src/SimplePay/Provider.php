<?php
  
  namespace LibX\SimplePay;

  use LibX\Util\Uuid;
  
  use InvalidArgumentException;

  /**
   * Provider
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Provider
  {
    // Types
    const TYPE_INCASSO       = 'incasso';
    const TYPE_IDEAL         = 'ideal';
    const TYPE_CREDITCARD    = 'creditcard';
    const TYPE_PREPAID       = 'prepaid';
    
    protected $uuid;
    protected $name;
    protected $type;
    
    /**
     * Construct a new Provider
     *
     * @param Uuid $uuid
     * @param string $name
     * @param string $type
     * @return Provider
     */
    public function __construct(Uuid $uuid, $name, $type)
    {
      $this->setUuid($uuid);
      $this->setName($name);
      $this->setType($type);
    }
    
    /**
     * Get uuid of this Provider
     *
     * @param void
     * @return Uuid
     */
    public function getUuid()
    {
      return $this->uuid;
    }
    
    /**
     * Set uuid of this Provider
     *
     * @param Uuid $uuid
     * @return void
     */
    public function setUuid(Uuid $uuid)
    {
      $this->uuid = $uuid;
    }
    
    /**
     * Get name of this Provider
     *
     * @param void
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }
    
    /**
     * Set name of this Provider
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
     * Get name of this Provider
     *
     * @param void
     * @return string
     */
    public function getType()
    {
      return $this->type;
    }
    
    /**
     * Set type of this Provider
     *
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
      if(!is_string($type) || strlen(trim($type)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid type, must be a non empty string');
        
      $this->type = $type;
    }
  }
  
?>