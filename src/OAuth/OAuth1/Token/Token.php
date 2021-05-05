<?php

  namespace LibX\OAuth\OAuth1\Token;

  class Token
  {
    const EOL_NEVER_EXPIRES = 9002;

    protected $requestToken;
    protected $requestTokenSecret;

    protected $accessToken;
    protected $accessTokenSecret;

    protected $refreshToken;

    protected $endOfLife;

    protected $extraParams = array();

    public function getRequestToken()
    {
      return $this->requestToken;
    }

    public function setRequestToken($requestToken)
    {
      $this->requestToken = $requestToken;
    }

    public function getRequestTokenSecret()
    {
      return $this->requestTokenSecret;
    }

    public function setRequestTokenSecret($requestTokenSecret)
    {
      $this->requestTokenSecret = $requestTokenSecret;
    }

    public function setAccessToken($accessToken)
    {
      $this->accessToken = $accessToken;
    }

    public function setAccessTokenSecret($accessTokenSecret)
    {
      $this->accessTokenSecret = $accessTokenSecret;
    }

    public function setEndOfLife($endOfLife)
    {
      $this->endOfLife = $endOfLife;
    }

    public function setExtraParams($extraParams)
    {
      $this->extraParams = $extraParams;
    }
  }

?>