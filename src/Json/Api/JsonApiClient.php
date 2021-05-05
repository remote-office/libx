<?php

  namespace LibX\Json\Api;

  use StdClass;
  
  /**
   * JSON API Client
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class JsonApiClient
  {
    // REST client
    protected $client;

    /**
     * Construct a JSON API Client
     *
     * @param void
     * @return JsonApiClient
     */
    public function __construct()
    {
      // Create a REST client
      $this->client = new \LibX\Net\Rest\Client();
    }

    /**
     * Make a REST call
     *
     * @param \LibX\Net\Rest\Request $request
     * @param \LibX\Net\Rest\Response $response
     * @return StdClass
     */
    protected function call(\LibX\Net\Rest\Request $request, \LibX\Net\Rest\Response $response)
    {
      // Make the call!
      $this->client->execute($request, $response);

      //print_r($request);
      //print_r($response);

      // Get info
      $info = $response->getInfo();

      // Get JSON response
      $json = $response->getData();

      // Decode JSON
      $data = json_decode($json);

      return $data;
    }
  }

?>