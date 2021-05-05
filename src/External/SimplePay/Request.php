<?php

  namespace LibX\External\SimplePay;

  /**
   * Request
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Request
  {
    protected $user;

    /**
     * Construct a new Request
     *
     * @param User $user
     * @return Request
     */
    public function __construct(User $user)
    {
      $this->setUser($user);
    }

    /**
     * Get user of this Request
     *
     * @param void
     * @return User
     */
    public function getUser()
    {
      return $this->user;
    }

    /**
     * Set user of this Request
     *
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
      $this->user = $user;
    }
  }

?>