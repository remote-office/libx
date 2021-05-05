<?php

  namespace LibX\OAuth2\Service;

  use LibX\OAuth2\Consumer\CredentialsInterface;
  use LibX\OAuth2\Storage\StorageInterface;
  use LibX\OAuth2\Token\TokenInterface;
  use LibX\Http\Client\ClientInterface;

  abstract class AbstractService implements ServiceInterface
  {
    protected $credentials;
    protected $client;
    protected $storage;

    protected $baseApiUrl = null;

    public function __construct(CredentialsInterface $credentials, ClientInterface $client, StorageInterface $storage, $scopes = [], $baseApiUri = null, $apiVersion = null)
    {
      $this->credentials = $credentials;
      $this->client = $client;
      $this->storage = $storage;

      $this->baseApiUrl = $baseApiUri;
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
      return $this->storage;
    }

    /**
     * @return string
     */
    public function service()
    {
      // Get class name without backslashes
      $classname = get_class($this);

      return preg_replace('/^.*\\\\/', '', $classname);
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationUri(array $additionalParameters = array())
    {
      $parameters = array_merge(
        $additionalParameters,
        array(
          'type'          => 'web_server',
          'client_id'     => $this->credentials->getConsumerId(),
          'redirect_uri'  => $this->credentials->getCallbackUrl(),
          'response_type' => 'code',
        )
      );

      /*$parameters['scope'] = implode($this->getScopesDelimiter(), $this->scopes);

      if ($this->needsStateParameterInAuthUrl()) {
          if (!isset($parameters['state'])) {
              $parameters['state'] = $this->generateAuthorizationState();
          }
          $this->storeAuthorizationState($parameters['state']);
      }*/

      // Build the url
      $url = clone $this->getAuthorizationEndpoint();

      foreach($parameters as $key => $val)
        $url->addToQuery($key, $val);

      return $url;
    }

    /**
     * {@inheritdoc}
     */
    public function requestAccessToken($code, $state = null)
    {
      if(!is_null($state))
        $this->validateAuthorizationState($state);

      $parameters = array(
        'code'          => $code,
        'client_id'     => $this->credentials->getConsumerId(),
        'client_secret' => $this->credentials->getConsumerSecret(),
        'redirect_uri'  => $this->credentials->getCallbackUrl(),
        'grant_type'    => 'authorization_code',
      );

      require_once 'libx/base.php';

      require_once 'libx/net/http/codes.class.php';
      require_once 'libx/net/rest/client.class.php';
      require_once 'libx/net/rest/request.class.php';
      require_once 'libx/net/rest/response.class.php';

      $request = new \LibXRestRequest($this->getAccessTokenEndpoint(), \LibXRestRequest::REQUEST_METHOD_POST);
      $request->setParameters($parameters);

      $response = new \LibXRestResponse();

      $client = new \LibXRestClient();
      $client->execute($request, $response);

      // Parse token
      $token = $this->parseAccessToken($response->getData());

      // Store token
      $this->storage->storeAccessToken($this->service(), $token);

      // Return token
      return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function requestAccessTokenDirect($state = null)
    {
      if(!is_null($state))
        $this->validateAuthorizationState($state);

      $parameters = array(
        'client_id'     => $this->credentials->getConsumerId(),
        'client_secret' => $this->credentials->getConsumerSecret(),
        'redirect_uri'  => $this->credentials->getCallbackUrl(),
        'grant_type'    => 'client_credentials',
      );

      require_once 'libx/base.php';

      require_once 'libx/net/http/codes.class.php';
      require_once 'libx/net/rest/client.class.php';
      require_once 'libx/net/rest/request.class.php';
      require_once 'libx/net/rest/response.class.php';

      $request = new \LibXRestRequest($this->getAccessTokenEndpoint(), \LibXRestRequest::REQUEST_METHOD_POST);
      $request->setParameters($parameters);

      $response = new \LibXRestResponse();

      $client = new \LibXRestClient();
      $client->execute($request, $response);

      // Parse token
      $token = $this->parseAccessToken($response->getData());

      // Store token
      $this->storage->storeAccessToken($this->service(), $token);

      // Return token
      return $token;
    }

    /**
     * Refreshes an OAuth2 access token.
     *
     * @param TokenInterface $token
     * @return TokenInterface $token
     * @throws MissingRefreshTokenException
     */
    public function refreshAccessToken(TokenInterface $token)
    {
      $refreshToken = $token->getRefreshToken();

      if(empty($refreshToken))
        throw new MissingRefreshTokenException();

      $parameters = array(
        'grant_type'    => 'refresh_token',
        'type'          => 'web_server',
        'client_id'     => $this->credentials->getConsumerId(),
        'client_secret' => $this->credentials->getConsumerSecret(),
        'refresh_token' => $refreshToken,
      );

      require_once 'libx/base.php';

      require_once 'libx/net/http/codes.class.php';
      require_once 'libx/net/rest/client.class.php';
      require_once 'libx/net/rest/request.class.php';
      require_once 'libx/net/rest/response.class.php';

      $request = new \LibXRestRequest($this->getAccessTokenEndpoint(), \LibXRestRequest::REQUEST_METHOD_POST);
      $request->setParameters($parameters);

      $response = new \LibXRestResponse();

      $client = new \LibXRestClient();
      $client->execute($request, $response);

      // Parse token
      $token = $this->parseAccessToken($response->getData());

      // Store token
      $this->storage->storeAccessToken($this->service(), $token);

      // Return token
      return $token;
    }

    public function request($path, $method = 'GET', $data, $baseApiUrl = null)
    {
      // Get token
      $token = $this->storage->retrieveAccessToken($this->service());

      require_once 'libx/base.php';

      require_once 'libx/net/http/codes.class.php';
      require_once 'libx/net/rest/client.class.php';
      require_once 'libx/net/rest/request.class.php';
      require_once 'libx/net/rest/response.class.php';

      if(strtoupper($method) == 'GET')
        $method = \LibXRestRequest::REQUEST_METHOD_GET;
      if(strtoupper($method) == 'POST')
        $method = \LibXRestRequest::REQUEST_METHOD_POST;

      if(!is_null($baseApiUrl))
        $url = $baseApiUrl . $path;
      else
        $url = $this->baseApiUrl . $path;

      $request = new \LibXRestRequest($url , $method);
      $request->setHeader('Authorization: Bearer ' . $token->getAccessToken());

      if(strtoupper($method) == 'POST')
      {
        if(!is_null($data) && is_array($data))
          $request->setParameters($data);
        else
          $request->setData($data);
      }

      //$request->setParameters($parameters);

      $response = new \LibXRestResponse();

      $client = new \LibXRestClient();
      $client->execute($request, $response);

      print_r($request);
      print_r($response);

      return $response->getData();
    }

    /**
     * Parses the access token and returns a TokenInterface.
     *
     * @abstract
     *
     * @param string $data
     * @return TokenInterface
     * @throws TokenResponseException
     */
    abstract protected function parseAccessToken($data);
  }

?>