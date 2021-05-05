<?php

  namespace LibX\OAuth\Consumer;

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