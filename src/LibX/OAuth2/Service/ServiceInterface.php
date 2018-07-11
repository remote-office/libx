<?php

  namespace LibX\OAuth2\Service;

  interface ServiceInterface
  {
    /**
     * Returns the url to redirect to for authorization purposes.
     *
     * @param array $additionalParameters
     *
     * @return UriInterface
     */
    public function getAuthorizationUri(array $additionalParameters = array());

    /**
     * Return the authorization endpoint
     *
     * @param void
     * @return UriInterface
     */
    public function getAuthorizationEndpoint();

    /**
     * Return the access token endpoint
     *
     * @param void
     * @return UriInterface
     */
    public function getAccessTokenEndpoint();
  }

?>