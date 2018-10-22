<?php

  namespace LibX\Util;

  use InvalidArgumentException;

	/**
	 * Uuid
	 *
	 * @author David Betgen <d.betgen@remote-office.nl>
	 * @version 1.0
	 */
	class Uuid
	{
		protected $uuid;

		/**
		 * Contruct a new Uuid
		 *
		 * @param string $uuid
		 * @return Uuid
		 */
		public function __construct($uuid = null)
		{
			if(!is_null($uuid))
			{
				if(!self::validate($uuid))
					throw new InvalidArgumentException(__METHOD__ . '; Invalid uuid');

				$this->uuid = $uuid;
			}
			else
			{
				$this->uuid = self::generate();
			}
		}

		/**
		 * Get the value of this Uuid
		 *
		 * @param void
		 * @return string
		 */
		public function getValue()
		{
			return $this->uuid;
		}

		/**
		 * Generate a new uuid
		 *
		 * @param void
		 * @return string
		 */
		static public function generate()
		{
			return self::uuid();
		}

		/**
		 * Validate if a string is an uuid
		 *
		 * @param string $uuid
		 * @return boolean true if string is an uuid, false otherwise
		 */
		static public function validate($uuid)
		{
			return (is_string($uuid) && preg_match('/^[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}$/', $uuid));
		}

		/**
		 * Uuid
		 *
		 * @param void
		 * @return string
		 */
		static protected function uuid()
		{
			// Use the random or the server name (if present) in the generation of UUID
			$base = md5(uniqid(rand(), true));

			// Mark as "random" UUID, set version
			$byte = hexdec( substr ($base, 12, 2));
			$byte = $byte & hexdec('0F');
			$byte = $byte | hexdec('40');
			$base = substr_replace($base, strtoupper (dechex ($byte)), 12, 2);

			// Set the variant
			$byte = hexdec (substr ($base, 16, 2));
			$byte = $byte & hexdec('3F');
			$byte = $byte | hexdec('80');
			$base = substr_replace($base, strtoupper (dechex ($byte)), 16, 2);

			// Format
			return strtolower(sprintf('%s-%s-%s-%s-%s', substr($base, 0, 8),	substr($base, 8, 4), substr($base, 12, 4), substr($base, 16, 4), substr($base, 20, 12)));
		}
	}

?>