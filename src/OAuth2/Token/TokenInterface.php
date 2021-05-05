<?php

  namespace LibX\OAuth2\Token;

  interface TokenInterface
  {
    public function getAccessToken();
    public function getRefreshToken();
    public function getExpiration();
    public function getParameters();

    public function setAccessToken($accessToken);
    public function setRefreshToken($refreshToken);
    public function setExpiration($lifetime);
    public function setParameters(array $parameters);
  }

?>