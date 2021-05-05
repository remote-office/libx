<?php

  namespace LibX\OAuth\Storage;

  //use LibX\OAuth\Token\TokenInterface;

  class Session implements StorageInterface
  {
    const SESSION_ACCESS_TOKEN = 'oauth_access_token';

    public function __construct()
    {
      if(!isset($_SESSION[self::SESSION_ACCESS_TOKEN]))
        $_SESSION[self::SESSION_ACCESS_TOKEN] = array();
    }

    public function retrieveAccessToken($service)
    {
      if($this->hasAccessToken($service))
        //return unserialize($_SESSION[self::SESSION_ACCESS_TOKEN][$service]);
        return $_SESSION[self::SESSION_ACCESS_TOKEN][$service];

      //throw new TokenNotFoundException('Token not found in session, are you sure you stored it?');
      throw new \Exception('Token not found in session, are you sure you stored it?');
    }

    //public function storeAccessToken($service, TokenInterface $token)
    public function storeAccessToken($service, $token)
    {
      //$serialized = serialize($token);
      $serialized = $token;

      if($_SESSION[self::SESSION_ACCESS_TOKEN] && is_array($_SESSION[self::SESSION_ACCESS_TOKEN][$service]))
        $_SESSION[self::SESSION_ACCESS_TOKEN][$service] = $serialized;
      else
        $_SESSION[self::SESSION_ACCESS_TOKEN] = array($service => $serialized);

      return $this;
    }

    public function hasAccessToken($service)
    {
      return isset($_SESSION[self::SESSION_ACCESS_TOKEN], $_SESSION[self::SESSION_ACCESS_TOKEN][$service]);
    }
  }

?>