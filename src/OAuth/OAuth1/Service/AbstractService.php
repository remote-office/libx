<?php

  namespace LibX\OAuth\OAuth1\Service;

  use LibX\OAuth\OAuth1\Token\Token;

  use LibX\OAuth\Consumer\CredentialsInterface;
  use LibX\OAuth\Storage\StorageInterface;
  use LibX\OAuth\Service\ServiceInterface;

  use LibX\Http\Uri\Uri;
  use LibX\Http\Uri\UriInterface;

  use LibX\Net\Rest\Request;

  /**
   * Class AbstractService
   *
   * @author David Betgen <db@yes-co.nl>
   * @version 1.0
   */
  abstract class AbstractService implements ServiceInterface
  {
    protected $credentials;
    protected $storage;

    /**
     * Construct an AbstractService
     *
     * @param CredentialsInterface $credentials
     * @param StorageInterface $storage
     * @return AbstractService
     */
    public function __construct(CredentialsInterface $credentials, StorageInterface $storage)
    {
      $this->credentials = $credentials;
      $this->storage = $storage;
    }

    /**
     * Request an request token from OAuth service
     *
     * @param vooid
     * @return \LibX\OAuth\OAuth1\Service\TokenInterface
     */
    public function getRequestToken()
    {
      // Set authorization header
      $header = $this->getAuthorizationHeaderForTokenRequest();

      // Create a REST client
      $client = new \LibX\Net\Rest\Client();

      $request = new \LibX\Net\Rest\Request($this->getRequestTokenEndpoint(), \LibX\Net\Rest\Request::REQUEST_METHOD_GET);
      $request->setHeader('Authorization: ' . $header);

      $response = new \LibX\Net\Rest\Response();

      $client->execute($request, $response);

      $data = $response->getData();

      $token = $this->parseRequestTokenResponse($data);

      $this->storage->storeAccessToken($this->service(), $token);

      return $token;
    }

    /**
     * Request an access token from OAuth service
     *
     * @param string $verifier
     * @return \LibX\OAuth\OAuth1\Service\TokenInterface
     */
    public function getAccessToken($verifier)
    {
      // Get request token
      $token = $this->storage->retrieveAccessToken($this->service());

      // Set additional parameters
      $additionalParameters = ['oauth_verifier' => $verifier];

      // Get authorization header
      $header = $this->getAuthorizationHeaderForApiRequest('GET', $this->getAccessTokenEndpoint(), $token, $additionalParameters);

      // Create a REST client
      $client = new \LibX\Net\Rest\Client();

      $request = new \LibX\Net\Rest\Request($this->getAccessTokenEndpoint(), \LibX\Net\Rest\Request::REQUEST_METHOD_GET);
      $request->setHeader('Authorization: ' . $header);

      $response = new \LibX\Net\Rest\Response();

      $client->execute($request, $response);

      $data = $response->getData();

      $token = $this->parseAccessTokenResponse($data);

      $this->storage->storeAccessToken($this->service(), $token);

      return $token;
    }

    public function sign(Request $request)
    {
      // Get access token
      $token = $this->storage->retrieveAccessToken($this->service());

      $uri = Uri::createFromString($request->getUrl());

      // Get authorization parameters
      $parameters = $this->getAuthorizationParametersForApiRequest($request->getMethod(), $uri, $token, $request->getParameters());

      // Set signed parameters
      $request->setParameters($parameters);

      return $request;
    }

    public function request($path, $method = 'GET', $body = null, array $extraHeaders = array())
    {
      $uri = Uri::createFromString($path);

      $token = $this->storage->retrieveAccessToken($this->service());

      // Get authorization parameters
      $parameters = $this->getAuthorizationParametersForApiRequest('GET', $uri, $token, []);

      // Parse URL
      parse_str($uri->getQuery(), $parsed);

      if(is_array($parsed))
        $parameters = array_merge($parameters, $parsed);

      // Create a REST client
      $client = new \LibX\Net\Rest\Client();

      $request = new \LibX\Net\Rest\Request($uri->getScheme() . '://' . $uri->getHost() . $uri->getPath(), \LibX\Net\Rest\Request::REQUEST_METHOD_GET);
      $request->setParameters($parameters);

      $response = new \LibX\Net\Rest\Response();

      $client->execute($request, $response);

      //print_r($request);
      //print_r($response);

      $data = $response->getData();

      return $data;
    }

    /**
     * Returns the authorization API endpoint.
     *
     * @param array $additionalParameters
     * @return UriInterface
     */
    public function getAuthorizationUri(array $additionalParameters = array())
    {
      // Build the url
      $uri = $this->getAuthorizationEndpoint();

      foreach($additionalParameters as $key => $val)
        $uri->addToQuery($key, $val);

      return $uri;
    }

    protected function getAuthorizationParametersForApiRequest($method = 'POST', UriInterface $uri, Token $token, $additionalParameters = null)
    {
      // Get OAuth parameters
      $parameters = $this->getOAuthParameters();

      // We don't need callback anymore in this request
      if(isset($parameters['oauth_callback']))
        unset($parameters['oauth_callback']);

      $parameters['oauth_token'] = $token->getRequestToken();

      if(is_array($additionalParameters))
        $parameters = array_merge($parameters, $additionalParameters);

      // Generate signature
      $parameters['oauth_signature'] = $this->buildSignature($uri, $parameters, $method, $token->getRequestTokenSecret());

      return $parameters;
    }

    protected function getAuthorizationHeaderForApiRequest($method = 'POST', UriInterface $uri, Token $token, $additionalParameters = null)
    {
      // Get OAuth parameters
      $parameters = $this->getAuthorizationParametersForApiRequest($method, $uri, $token, $additionalParameters);

      $authorizationHeader = 'OAuth ';

      $delimiter = '';

      foreach ($parameters as $key => $value) {
          $authorizationHeader .= $delimiter . rawurlencode($key) . '="' . rawurlencode($value) . '"';
          $delimiter = ', ';
      }

      return $authorizationHeader;
    }


    protected function getAuthorizationParametersForTokenRequest()
    {
      // Get OAuth parameters
      $parameters = $this->getOAuthParameters();

      // Generate signature
      $parameters['oauth_signature'] = $this->buildSignature($this->getRequestTokenEndpoint(), $parameters, 'GET');

      return $parameters;
    }


    protected function getAuthorizationHeaderForTokenRequest()
    {
      // Get OAuth parameters
      $parameters = $this->getAuthorizationParametersForTokenRequest();


      $authorizationHeader = 'OAuth ';

      $delimiter = '';

      foreach ($parameters as $key => $value) {
          $authorizationHeader .= $delimiter . rawurlencode($key) . '="' . rawurlencode($value) . '"';
          $delimiter = ', ';
      }

      return $authorizationHeader;
    }


    protected function getOAuthParameters()
    {
      // Generate timestamp
      $timestamp = time();

      // Generate nonce
      $nonce = uniqid();

      $parameters = [];
      $parameters['oauth_callback'] = $this->credentials->getCallbackUrl();
      $parameters['oauth_consumer_key'] = $this->credentials->getConsumerId();
      $parameters['oauth_nonce'] = $nonce;
      $parameters['oauth_signature_method'] = $this->getSignatureMethod();
      $parameters['oauth_timestamp'] = $timestamp;
      $parameters['oauth_version'] = $this->getVersion();

      return $parameters;
    }

    /**
     * @return string
     */
    protected function getSignatureMethod()
    {
        return 'HMAC-SHA1';
    }

   /**
     * This returns the version used in the authorization header of the requests
     *
     * @return string
     */
    protected function getVersion()
    {
        return '1.0';
    }


    private function buildSignature(UriInterface $uri, array $parameters, $method = 'POST', $tokenSecret = null)
    {
      // Parse URL query
      parse_str($uri->getQuery(), $parsed);

      foreach(array_merge($parsed, $parameters) as $key => $value)
        $signatureData[rawurlencode($key)] = rawurlencode($value);

      ksort($signatureData);

      $baseUri = $uri->getScheme() . '://' . $uri->getRawAuthority();
      $baseUri .= $uri->getPath();

      $baseString = strtoupper($method) . '&';
      $baseString .= rawurlencode($baseUri) . '&';
      $baseString .= rawurlencode($this->buildSignatureDataString($signatureData));

      return base64_encode($this->hash($baseString, $tokenSecret));
    }

    private function buildSignatureDataString(array $signatureData)
    {
      $signatureString = '';

      $delimiter = '';

      foreach ($signatureData as $key => $value)
      {
        $signatureString .= $delimiter . $key . '=' . $value;
        $delimiter = '&';
      }

      return $signatureString;
    }

   /**
     * @return string
     */
    protected function getSigningKey($tokenSecret = null)
    {
        $signingKey = rawurlencode($this->credentials->getConsumerSecret()) . '&';

        if($tokenSecret !== null)
          $signingKey .= rawurlencode($tokenSecret);

        return $signingKey;
    }

    private function hash($data, $tokenSecret = null)
    {
      return hash_hmac('sha1', $data, $this->getSigningKey($tokenSecret), true);
    }

    /**
     * Parses the request token response and returns a TokenInterface.
     * This is only needed to verify the `oauth_callback_confirmed` parameter. The actual
     * parsing logic is contained in the access token parser.
     *
     * @abstract
     * @param string $responseBody
     * @return TokenInterface
     * @throws TokenResponseException
     */
    abstract protected function parseRequestTokenResponse($response);

    /**
     * Parses the access token response and returns a TokenInterface.
     *
     * @abstract
     * @param string $responseBody
     * @return TokenInterface
     * @throws TokenResponseException
     */
    abstract protected function parseAccessTokenResponse($response);



    /**
     * @return string
     */
    public function service()
    {
        // get class name without backslashes
        $classname = get_class($this);
        return preg_replace('/^.*\\\\/', '', $classname);
    }
  }

?>