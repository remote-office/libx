<?php

  namespace LibX\OAuth2\Token;

  class Token implements TokenInterface
  {
    protected $accesToken;
    protected $refreshToken;
    protected $expiration;
    protected $parameters;

    public function getAccessToken()
    {
      return $this->accesToken;
    }

    public function getRefreshToken()
    {
      return $this->refreshToken;
    }

    public function getExpiration()
    {
      return $this->expiration;
    }

    public function getParameters()
    {
      return $this->parameters;
    }

    public function setAccessToken($accessToken)
    {
      $this->accesToken = $accessToken;
    }

    public function setRefreshToken($refreshToken)
    {
      $this->refreshToken = $refreshToken;
    }

    public function setExpiration($lifetime)
    {
      // Calc expiration
      $this->expiration = intval($lifetime) + time();
    }

    public function setParameters(array $parameters)
    {
      $this->parameters = $parameters;
    }

    public function isExpired()
    {
      return (time() > $this->expiration);
    }
  }

?>