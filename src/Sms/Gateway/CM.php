<?php

  namespace LibX\Sms\Gateway;

  class CM implements GatewayInterface
  {
    protected $token;
    protected $url;

    public function __construct($token, $url)
    {
      $this->token = $token;
      $this->url = $url;
    }

    public function send($sender, $recipient, $content)
    {
      // Create SMS XML
      $xml = new \SimpleXMLElement('<MESSAGES/>');

      $xml->addChild('AUTHENTICATION');
      $xml->AUTHENTICATION->addChild('PRODUCTTOKEN', $this->token);

      $xml->addChild('TARIFF');
      $xml->TARIFF = 0;

      $xml->addChild('MSG');

      $xml->MSG->addChild('FROM');
      $xml->MSG->FROM = $sender;

      $xml->MSG->addChild('BODY');
      $xml->MSG->BODY = $content;

      $xml->MSG->addChild('TO');
      $xml->MSG->TO = $recipient;

      // Convert to xml string
      $message = $xml->asXML();

      echo $message . "\n";

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $this->url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml', 'Content-length: ' . strlen($message)));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $return = curl_exec($ch);

      echo $return . "\n";

      curl_close($ch);

      return $return;
    }
  }

?>