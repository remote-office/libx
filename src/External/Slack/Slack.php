<?php

  namespace LibX\External\Slack;

  class Slack
  {
    protected $team;
    protected $service;
    protected $token;

    protected $channel;

    /**
     * Construct a Slack
     *
     * @param string $team (TXXXXX)
     * @param string $service (BXXXXX)
     * @param string $token (XXXXXXXXXX)
     * @return Slack
     */
    public function __construct($team, $service, $token)
    {
      $this->team = $team;
      $this->service = $service;
      $this->token = $token;
    }

    public function send($user, $channel, $text, $attachment = null)
    {
      try
      {
        // Payload
        $payload =
        [
          'text' => $text,
          'channel' => '#' . $channel,
          'username' => $user,
          'link_names' => 1
        ];

        // Concat url
        $url = 'https://hooks.slack.com/services/' . $this->team . '/' . $this->service . '/' . $this->token;

        // Create a REST client
        $client = new \LibX\Net\Rest\Client();

        // Create a REST request and response
        $request = new \LibX\Net\Rest\Request($url, \LibX\Net\Rest\Request::REQUEST_METHOD_POST);
        $request->setHeader('Content-type: application/json');

        $request->setData(json_encode($payload, JSON_UNESCAPED_UNICODE));

        $response = new \LibX\Net\Rest\Response();

        // Execute
        $client->execute($request, $response);
      }
      catch(\Exception $exception)
      {
        print_r($exception);
      }
    }
  }

?>