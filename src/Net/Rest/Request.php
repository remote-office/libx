<?php

  namespace LibX\Net\Rest;

  use Exception;
  use InvalidArgumentException;
  
  /**
  * Class Request
  *
  * @author David Betgen <d.betgen@remote-office.nl>
  * @version 1.0
  */
  class Request
  {
    // Request methods
    const REQUEST_METHOD_GET      = 'GET';
    const REQUEST_METHOD_POST     = 'POST';
    const REQUEST_METHOD_PUT      = 'PUT';
    const REQUEST_METHOD_DELETE   = 'DELETE';
    const REQUEST_METHOD_HEAD     = 'HEAD';

    protected $headers;

    protected $url;
    protected $method;

    protected $timeout;

    protected $parameters;
    protected $data;
    protected $resource;

    // Used for authentication
    protected $username;
    protected $password;

    /**
    * Construct a Request
    *
    * @param string $url
    * @param string $method
    * @return Request
    */
    public function __construct($url, $method = self::REQUEST_METHOD_GET)
    {
      $this->setUrl($url);
      $this->setMethod($method);
    }

    /**
     * Get custom headers of this Request
     *
     * @param void
     * @return array
     */
    public function getHeaders()
    {
      return $this->headers;
    }

    /**
     * Set custom headers of this Request
     *
     * @param array $headers
     * @return void
     */
    public function setHeaders($headers)
    {
      $this->headers = $headers;
    }

    /**
     * Check if this Request has custom headers
     *
     * @param void
     * @return boolean
     */
    public function hasHeaders()
    {
      return !is_null($this->headers);
    }

    public function getHeader($name)
    {
      if(!$this->hasHeaders())
        throw new Exception(__METHOD__ . '; No headers');

      // Search headers
      foreach($this->headers as $header)
      {
        if(stripos($header, $name) === 0)
          return trim(substr($header, strlen($name) + 1));
      }
    }

    public function setHeader($header)
    {
      if(!$this->hasHeaders())
        $this->headers = array();

      $this->headers[] = $header;
    }

    public function hasHeader($name)
    {
      if(!$this->hasHeaders())
        throw new Exception(__METHOD__ . '; No headers');

      // Search headers
      foreach($this->headers as $header)
      {
        if(stripos($header, $name) === 0)
          return true;
      }

      return false;
    }


    /**
    * Get url of this Request
    *
    * @param void
    * @return string
    */
    public function getUrl()
    {
      return $this->url;
    }

    /**
    * Set url of this Request
    *
    * @param string $url
    * @return void
    */
    public function setUrl($url)
    {
      if(!is_string($url) && strlen(trim($url)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid url, must be a non empty string');

      $this->url = $url;
    }

    /**
    * Get method of this Request
    *
    * @param void
    * @return string
    */
    public function getMethod()
    {
      return $this->method;
    }

    /**
    * Set method of this Request
    *
    * @param string $method
    * @return void
    */
    public function setMethod($method)
    {
      if(!is_string($method) && strlen(trim($method)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid method, must be a non empty string');

      $this->method = $method;
    }

    /**
    * Get timeout of this Request
    *
    * @param void
    * @return integer
    */
    public function getTimeout()
    {
      return $this->timeout;
    }

    /**
    * Set timeout of this Request
    *
    * @param integer $timeout
    * @return void
    */
    public function setTimeout($timeout)
    {
      if(!is_int($timeout) || $timeout < 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid timeout, must be a non negative integer');

      $this->timeout = $timeout;
    }

    /**
    * Check if this Request has a timeout
    *
    * @param void
    * @return boolean
    */
    public function hasTimeout()
    {
      return !is_null($this->timeout);
    }

    /**
    * Get parameters of this Request
    *
    * @param void
    * @return array
    */
    public function getParameters()
    {
      return $this->parameters;
    }

    /**
    * Set parameters of this Request
    *
    * @param array $parameters
    * @return void
    */
    public function setParameters($parameters)
    {
      if(!is_array($parameters))
        throw new InvalidArgumentException(__METHOD__ . '; Invalid parameters, must be an array');

      $this->parameters = $parameters;
    }

    /**
    * Check if this Request has parameters
    *
    * @param void
    * @return boolean
    */
    public function hasParameters()
    {
      return !is_null($this->parameters);
    }

    /**
    * Get data of this Request
    *
    * @param void
    * @return array
    */
    public function getData()
    {
      return $this->data;
    }

    /**
    * Set data of this Request
    *
    * @param string $data
    * @return void
    */
    public function setData($data)
    {
      if(!is_string($data) && strlen(trim($data)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid data, must be a non empty string');

      $this->data = $data;
    }

    /**
    * Check if this Request has data
    *
    * @param void
    * @return boolean
    */
    public function hasData()
    {
      return !is_null($this->data);
    }

    /**
    * Get resource of this Request
    *
    * @param void
    * @return resource
    */
    public function getResource()
    {
      return $this->resource;
    }

    /**
    * Set resource of this Request
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
    * Check if this Request has a resource
    *
    * @param void
    * @return boolean
    */
    public function hasResource()
    {
      return !is_null($this->resource);
    }

    /**
    * Get username of this Request
    *
    * @param void
    * @return string
    */
    public function getUsername()
    {
      return $this->username;
    }

    /**
    * Set username of this Request
    *
    * @param string $username
    * @return void
    */
    public function setUsername($username)
    {
      if(!is_string($username) && strlen(trim($username)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid username, must be a non empty string');

      $this->username = $username;
    }

    /**
    * Check if this Request has an username
    *
    * @param void
    * @return boolean
    */
    public function hasUsername()
    {
      return !is_null($this->username);
    }

    /**
    * Get password of this Request
    *
    * @param void
    * @return string
    */
    public function getPassword()
    {
      return $this->password;
    }

    /**
    * Set password of this Request
    *
    * @param string $password
    * @return void
    */
    public function setPassword($password)
    {
      if(!is_string($password) && strlen(trim($password)) == 0)
        throw new InvalidArgumentException(__METHOD__ . '; Invalid password, must be a non empty string');

      $this->password = $password;
    }

    /**
    * Check if this Request has an username
    *
    * @param void
    * @return boolean
    */
    public function hasPassword()
    {
      return !is_null($this->password);
    }
  }

?>
