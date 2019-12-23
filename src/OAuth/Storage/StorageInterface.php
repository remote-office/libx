<?php

  namespace LibX\OAuth\Storage;

  //use LibX\OAuth\Token\TokenInterface;

  interface StorageInterface
  {
    public function retrieveAccessToken($service);
    //public function storeAccessToken($service, TokenInterface $token);
    public function storeAccessToken($service, $token);
    public function hasAccessToken($service);
  }

?>