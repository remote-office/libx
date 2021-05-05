<?php

  namespace LibX\External\SimplePay\Request;

  use LibX\External\SimplePay\Request;
  use LibX\External\SimplePay\User;

  use InvalidArgumentException;

	/**
	 * ProviderRequest
	 *
	 * @author David Betgen <d.betgen@remote-office.nl>
	 * @version 1.0
	 */
  class ProviderRequest extends Request
	{
	  protected $type;

		/**
		 * Construct a new ProviderRequest
		 *
		 * @param User $user
		 * @param string $type
		 * @return ProviderRequest
		 */
		public function __construct(User $user, $type = null)
		{
			$this->setUser($user);

			if(!is_null($type))
			 $this->setType($type);
		}

	  /**
     * Get name of this ProviderRequest
     *
     * @param void
     * @return string
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * Set type of this ProviderRequest
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

    /**
     * Check if type of this ProviderRequest is set
     *
     * @param void
     * @return boolean
     */
    public function hasType()
    {
      return !is_null($this->type);
    }
	}

?>