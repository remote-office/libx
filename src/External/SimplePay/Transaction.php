<?php

  namespace LibX\External\SimplePay;

  use LibX\Util\Uuid;

  /**
   * Transaction
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Transaction
  {
    // Status
    const STATUS_OPEN       = 'open';
    const STATUS_CANCELLED  = 'cancelled';
    const STATUS_EXPIRED    = 'expired';
    const STATUS_FAILED     = 'failed';
    const STATUS_SUCCESS    = 'success';

    protected $uuid;
    protected $status;

    /**
     * Construct a Transaction
     *
     * @param Uuid $uuid
     * @param string $status
     * @return Transaction
     */
    public function __construct(Uuid $uuid, $status)
    {
      $this->setUuid($uuid);
      $this->setStatus($status);
    }

    /**
     * Get uuid of this Transaction
     *
     * @param void
     * @return Uuid
     */
    public function getUuid()
    {
      return $this->uuid;
    }

    /**
     * Set uuid of this Transaction
     *
     * @param Uuid $uuid
     * @return void
     */
    public function setUuid(Uuid $uuid)
    {
      $this->uuid = $uuid;
    }

    /**
     * Get status of this Transaction
     *
     * @param void
     * @return string
     */
    public function getStatus()
    {
      return $this->status;
    }

    /**
     * Set status of this Transaction
     *
     * @param string $status
     * @return void
     */
    public function setStatus($status)
    {
      $this->status = $status;
    }
  }

?>