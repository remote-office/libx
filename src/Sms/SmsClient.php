<?php

  namespace LibX\Sms;

  use LibX\Sms\Gateway\GatewayInterface;

  class SmsClient
  {
    protected $gateway;

    public function __construct(GatewayInterface $gateway)
    {
      $this->gateway = $gateway;
    }

    public function send($sender, $recipient, $content)
    {
      $this->gateway->send($sender, $recipient, $content);
    }
  }