<?php

  namespace LibX\Sms\Gateway;

  interface GatewayInterface
  {
    public function send($sender, $recipient, $content);
  }

?>