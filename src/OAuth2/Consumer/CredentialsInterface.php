<?php

  namespace LibX\OAuth2\Consumer;

  interface CredentialsInterface
  {
    /**
     * @return string
     */
    public function getCallbackUrl();

    /**
     * @return string
     */
    public function getConsumerId();

    /**
     * @return string
     */
    public function getConsumerSecret();
  }

?>