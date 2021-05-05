<?php

  namespace LibX\OAuth\Storage;


  class File implements StorageInterface
  {
    public function retrieveAccessToken($service)
    {
      $serialized = file_get_contents('/tmp/' . $service . '.token');

      $token = unserialize($serialized);

      return $token;
    }

    //public function storeAccessToken($service, TokenInterface $token);

    public function storeAccessToken($service, $token)
    {
      file_put_contents('/tmp/' . $service . '.token', serialize($token));
    }

    public function hasAccessToken($service)
    {
      return file_exists('/tmp/' . $service . '.token');
    }
  }

?>