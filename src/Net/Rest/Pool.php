<?php

  namespace LibX\Net\Rest;

  /**
   * Pool
   *
   * Factory for REST clients
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  abstract class Pool
  {
    private static $instances = array();

    /**
     * Return an instance of a LibX\Net\Rest\Client with a specific label
     *
     * @param string $label
     * @return \LibX\Net\Rest\Client
     */
    public static function getInstance($label = 'default')
    {
      $instance = null;

      if(!isset(self::$instances[$label]))
      {
          // Create new Client
          $client = new Client();

          // Save the instance
          self::$instances[$label] = $client;
      }

      $instance = self::$instances[$label];

      return $instance;
    }
  }

?>