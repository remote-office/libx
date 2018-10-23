<?php

  namespace LibX\Net\Rest;

  use Exception;
  use InvalidArgumentException;

  /**
   * Class Client
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Client
  {
   /**
    * Construct a Client
    *
    * @param void
    * @return Client
    */
    public function __construct()
    {
    }

    /**
     * Destruct a Client
     *
     * @param voud
     * @return void
     */
    public function __destruct()
    {
    }

    /**
     * Do rest call
     *
     * @param Request $request
     * @param Request $response
     * @throws Exception
     */
    public function execute(Request $request, Response $response)
    {
      // Open curl handler
      $handle = curl_init();

      // Set header callback
      curl_setopt($handle, CURLOPT_HEADERFUNCTION, array(&$response, 'header'));

      // Do not reuse connection
      curl_setopt($handle, CURLOPT_FORBID_REUSE, 1);
      curl_setopt($handle, CURLOPT_FRESH_CONNECT, 1);

      // Clear default "Expect: 100-continue" header
      //curl_setopt($handle, CURLOPT_HTTPHEADER, array('Expect:'));

      // Set custom headers
      if($request->hasHeaders())
      {
        curl_setopt($handle, CURLOPT_HEADER, 0);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $request->getHeaders());
      }

      // Set authentication if needed
      if($request->hasUsername() && $request->hasPassword())
      {
        curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($handle, CURLOPT_USERPWD, $request->getUsername() . ':' . $request->getPassword());
      }

      // Set timeout
      if($request->hasTimeout())
        curl_setopt($handle, CURLOPT_TIMEOUT, $request->getTimeout());

      // Set curl options
      curl_setopt($handle, CURLOPT_URL, $request->getUrl());
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

      curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
      //curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);

      curl_setopt($handle, CURLOPT_FOLLOWLOCATION, 1);

      // Get method
      $method = $request->getMethod();

      if(!method_exists($this, strtolower($method)))
        throw new Exception(__METHOD__ . '; Request method "' .$method . '" not supported');

      // Call request method handler
      call_user_func(array($this, strtolower($method)),  $handle, $request, $response);

      // Execute curl request
      curl_exec($handle);

      // Get info
      $info = curl_getinfo($handle);

      // Set info
      $response->setInfo($info);

      // Close curl handler
      if(!is_null($handle) && is_resource($handle))
        curl_close($handle);
    }

    protected function head($handle, Request $request, Response $response)
    {
      // Set write callback
      curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'HEAD');
      curl_setopt($handle, CURLOPT_NOBODY, true);

      if($request->hasParameters())
      {
        // Build http query
        $data = http_build_query($request->getParameters(), '', '&');

        // Override curl url option
        curl_setopt($handle, CURLOPT_URL, $request->getUrl() . '?' . $data);
      }
    }

    protected function get($handle, Request $request, Response $response)
    {
      // Set write callback
      curl_setopt($handle, CURLOPT_WRITEFUNCTION, array(&$response, 'write'));

      if($request->hasParameters())
      {
        // Build http query
        $data = http_build_query($request->getParameters(), '', '&');

        // Override curl url option
        curl_setopt($handle, CURLOPT_URL, $request->getUrl() . '?' . $data);
      }
    }

    protected function post($handle, Request $request, Response $response)
    {
      if(!$request->hasParameters() && !$request->hasData())
        throw new InvalidArgumentException(__METHOD__ . '; Invalid request parameters or data for POST method, must be an array or string');

      // Build http query
      if($request->hasParameters())
        $data = http_build_query($request->getParameters(), '', '&');
      elseif($request->hasData())
        $data = $request->getData();

      // Set write callback
      curl_setopt($handle, CURLOPT_WRITEFUNCTION, array(&$response, 'write'));

      curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
      curl_setopt($handle, CURLOPT_POST, true);
    }

    protected function put($handle, Request $request, Response $response)
    {
      if($request->hasResource())
      {
        // Set read callback
        curl_setopt($handle, CURLOPT_READFUNCTION, array(&$response, 'read'));
        curl_setopt($handle, CURLOPT_INFILE, $request->getResource());

        // Set PUT
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
      }
      else
      {
        if(!$request->hasParameters() && !$request->hasData())
          throw new InvalidArgumentException(__METHOD__ . '; Invalid request parameters or data for PUT method, must be an array or string');

        // Build http query
        if($request->hasParameters())
          $data = http_build_query($request->getParameters(), '', '&');
        elseif($request->hasData())
          $data = $request->getData();

        // Set write callback
        curl_setopt($handle, CURLOPT_WRITEFUNCTION, array(&$response, 'write'));

        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($handle, CURLOPT_PUT, true);

        // Set PUT
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
      }
    }

    protected function delete($handle, Request $request, Response $response)
    {
      // Set write callback
      curl_setopt($handle, CURLOPT_WRITEFUNCTION, array(&$response, 'write'));

      if($request->hasParameters())
      {
        // Build http query
        $data = http_build_query($request->getParameters(), '', '&');

        // Override curl url option
        curl_setopt($handle, CURLOPT_URL, $request->getUrl() . '?' . $data);
      }

      curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }
  }

?>
