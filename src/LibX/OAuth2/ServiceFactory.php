<?php

  namespace LibX\OAuth2;

  use LibX\OAuth2\Consumer\CredentialsInterface;
  use LibX\OAuth2\Storage\StorageInterface;

  use LibX\OAuth2\Service\Yesco;
use LibX\Http\Client\ClientInterface;
use LibX\Http\Client\CurlClient;

  /**
   * Class ServiceFactory
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class ServiceFactory
  {
    protected $client;

    /**
     * Set http client
     *
     * @param ClientInterface $client
     * @return ServiceFactory
     */
    public function setClient(ClientInterface $client)
    {
      $this->client = $client;

      return $this;
    }

    /**
     * Create an oauth2 service
     *
     * @param string $name
     * @param CredentialsInterface $credentials
     * @param StorageInterface $storage
     * @param array $scope
     * @param UriInterface $baseApiUri
     * @param string $apiVersion
     * @return ServiceInterface
     */
    public function create($name, CredentialsInterface $credentials, StorageInterface $storage, $scopes = [], $baseApiUri = null, $apiVersion = null)
    {
      $name = ucfirst($name);

      if(is_null($this->client))
        $this->client = new CurlClient();

      $class = '\\LibX\OAuth2\\Service\\' . $name;

      if(!class_exists($class))
        throw new \Exception('Service with name ' . $name . ' not found');

      return new $class($credentials, $this->client, $storage, $scopes, $baseApiUri);
    }
  }

?>