<?php

  namespace LibX\OAuth2\Service;

  use LibX\Http\Uri\Uri;

  use LibX\OAuth2\Token\Token;

  class Yesco extends AbstractService
  {
    public function __construct($credentials, $client, $storage, $scopes, $baseApiUri)
    {
      parent::__construct($credentials, $client, $storage, $scopes, $baseApiUri);

      if(is_null($baseApiUri))
        $this->baseApiUri = Uri::createFromString('http://oauth2.yes-co.com');
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorizationEndpoint()
    {
      return Uri::createFromString('http://oauth2.yes-co.com/oauth/authorize');
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessTokenEndpoint()
    {
      return Uri::createFromString('http://oauth2.yes-co.com/oauth/access_token');
    }

    /**
     * {@inheritdoc}
     */
    protected function parseAccessToken($json)
    {
      $data = json_decode($json, true);

      // @TODO: Check data for exceptions

      $token = new Token();
      $token->setAccessToken($data['access_token']);
      unset($data['access_token']);

      if(isset($data['expires_in']))
      {
        $token->setExpiration($data['expires_in']);
        unset($data['expires_in']);
      }

      if(isset($data['refresh_token']))
      {
        $token->setRefreshToken($data['refresh_token']);
        unset($data['refresh_token']);
      }

      if(!empty($data))
        $token->setParameters($data);

      return $token;
    }
  }

?>