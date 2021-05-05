<?php

  namespace LibX\OAuth2\Storage;

  use LibX\OAuth2\Token\TokenInterface;

  interface StorageInterface
  {
    public function retrieveAccessToken($service);
    public function storeAccessToken($service, TokenInterface $token);
    public function hasAccessToken($service);
  }

?>