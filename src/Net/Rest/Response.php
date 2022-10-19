<?php

  namespace LibX\Net\Rest;

  use Exception;
  use InvalidArgumentException;
  
  /**
  * Class Response
  *
  * @author David Betgen <d.betgen@remote-office.nl>
  * @version 1.0
  */
  class Response
  {
    public $headers;
    protected $data;

    protected $info;

    protected $resource;

    // User callback hooks
    protected $userCallbackHeader;
    protected $userCallbackWrite;
    protected $userCallbackRead;

    /**
    * Construct a Response
    *
    * @param void
    * @return Response
    */
    public function __construct()
    {
    }

    /**
    * Get headers of this Response
    *
    * @param void
    * @return array
    */
    public function getHeaders()
    {
      return $this->headers;
    }

    public function getHeader($name)
    {
      // Split headers into array
      $headers = preg_split('/\n|\r\n/', $this->headers);

      // Search headers
      foreach($headers as $header)
      {
        if(stripos($header, $name) === 0)
          return trim(substr($header, strlen($name) + 1));
      }
    }

    /**
    * Set headers of this Response
    *
    * @param array $headers
    * @return void
    */
    public function setHeaders($headers)
    {
      if(!is_array($headers))
        throw new InvalidArgumentException(__METHOD__ . '; Invalid header, must be a array');

      $this->headers = $headers;
    }

    public function setHeader($header)
    {
      $this->headers[] = $header;
    }

    /**
    * Get data of this Response
    *
    * @param void
    * @return string
    */
    public function getData()
    {
      return $this->data;
    }

    /**
    * Set data of this Response
    *
    * @param string $data
    * @return void
    */
    public function setData($data)
    {
      if(!is_string($data))
        throw new InvalidArgumentException(__METHOD__ . '; Invalid data, must be a string');

      $this->data = $data;
    }

    /**
    * Get info of this Response
    *
    * @param void
    * @return array
    */
    public function getInfo()
    {
      return $this->info;
    }

    /**
    * Set info of this Response
    *
    * @param array $info
    * @return void
    */
    public function setInfo($info)
    {
      if(!is_array($info))
        throw new InvalidArgumentException(__METHOD__ . '; Invalid info must be an array');

      $this->info = $info;
    }

    /**
    * Get resource of this Response
    *
    * @param void
    * @return resource
    */
    public function getResource()
    {
      return $this->resource;
    }

    /**
    * Set resource of this Response
    *
    * @param resource $resource
    * @return void
    */
    public function setResource($resource)
    {
      if(!is_resource($resource))
        throw new InvalidArgumentException(__METHOD__ . '; Invalid resource, must be a resource');

      $this->resource = $resource;
    }

    /**
    * Check if this Response has a resource
    *
    * @param void
    * @return boolean
    */
    public function hasResource()
    {
      return !is_null($this->resource);
    }


    /**
     * Header callback
     *
     * @param resource $handle
     * @param string $header
     * @return void
     */
    public function header($handle, $header)
    {
      if(!is_object($handle))
        throw new Exception(__METHOD__ . '; cURL handle is not valid');

      $length = strlen($header);

      $this->headers .= $header;

      /*// Trim header (newline)
      $header = rtrim($header);

      if(strlen($header) > 0)
        $this->headers[] = $header;*/

      return $length;
    }

    /**
     * Write callback
     *
     * @param $handle
     * @param $data
     * @return integer
     */
    public function write($handle, $data)
    {
      if(!is_object($handle))
        throw new Exception(__METHOD__ . '; cURL handle is not valid');

      $length = strlen($data);

      if($this->hasResource())
        fwrite($this->getResource(), $data, $length);
      else
        $this->data .= $data;

      return $length;
    }

    /**
     * Read callback
     *
     * @param $handle
     * @param $fd
     * @param $length
     * @return string
     */
    public function read($handle, $fd, $length)
    {
      if(!is_object($handle))
        throw new Exception(__METHOD__ . '; cURL handle is not valid');

      $data = fread($fd, $length);
      $len = strlen($data);

      return $data;
    }

    public function getUserCallbackHeader()
    {
      return $this->userCallbackHeader;
    }

    public function setUserCallbackHeader($userCallbackHeader)
    {
      if(!$userCallbackHeader instanceof callback)
        throw new Exception(__METHOD__ . '; Invalid user callback, must be a callback');

      $this->userCallbackHeader = $userCallbackHeader;
    }

    public function hasUserCallbackHeader()
    {
      return !is_null($this->userCallbackHeader);
    }

    public function getUserCallbackWrite()
    {
      return $this->userCallbackWrite;
    }

    public function setUserCallbackWrite($userCallbackWrite)
    {
      if(!$userCallbackWrite instanceof callback)
        throw new Exception(__METHOD__ . '; Invalid user callback, must be a callback');

      $this->userCallbackWrite = $userCallbackWrite;
    }

    public function hasUserCallbackWrite()
    {
      return !is_null($this->userCallbackWrite);
    }

    public function getUserCallbackRead()
    {
      return $this->userCallbackRead;
    }

    public function setUserCallbackRead($userCallbackRead)
    {
      if(!$userCallbackRead instanceof callback)
        throw new Exception(__METHOD__ . '; Invalid user callback, must be a callback');

      $this->userCallbackRead = $userCallbackRead;
    }

    public function hasUserCallbackRead()
    {
      return !is_null($this->userCallbackRead);
    }
  }

?>
