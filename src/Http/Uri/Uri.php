<?php

  namespace LibX\Http\Uri;

  use InvalidArgumentException;

  class Uri implements UriInterface
  {
    protected $scheme;   // Uri scheme.
    protected $host;     // Uri host.
    protected $port;     // Uri port number.
    protected $path;     // Uri path.
    protected $query;    // Uri query string.
    protected $fragment; // Uri fragment.
    protected $user;     // Uri user.
    protected $password; // Uri password.

    protected $uri;

    /**
     * Construct a Uri
     * @param string $scheme
     * @param string $host
     * @param integer $port
     * @param string $path
     * @param string $query
     * @param string $fragment
     * @param string $user
     * @param string $password
     */
    public function __construct($scheme, $host, $port = null, $path = '/', $query = '', $fragment = '', $user = '', $password = '', $uri = null)
    {
      $this->scheme = $scheme;
      $this->host = $host;
      $this->port = $port;
      $this->path = empty($path) ? '/' : $path;
      $this->query = $query;
      $this->fragment = $fragment;
      $this->user = $user;
      $this->password = $password;

      $this->uri = $uri;
    }

    public static function createFromString($uri)
    {
      if(!is_string($uri) && !method_exists($uri, '__toString'))
        throw new InvalidArgumentException('Uri must be a string');

      $parts = parse_url($uri);
      $scheme = isset($parts['scheme']) ? $parts['scheme'] : '';
      $user = isset($parts['user']) ? $parts['user'] : '';
      $pass = isset($parts['pass']) ? $parts['pass'] : '';
      $host = isset($parts['host']) ? $parts['host'] : '';
      $port = isset($parts['port']) ? $parts['port'] : null;
      $path = isset($parts['path']) ? $parts['path'] : '';
      $query = isset($parts['query']) ? $parts['query'] : '';
      $fragment = isset($parts['fragment']) ? $parts['fragment'] : '';

      return new static($scheme, $host, $port, $path, $query, $fragment, $user, $pass, $uri);
    }

    public function getScheme()
    {
      return $this->scheme;
    }

    public function getHost()
    {
      return $this->host;
    }

    public function getPort()
    {
      return $this->port;
    }

    public function hasPort()
    {
      return !is_null($this->port);
    }

    public function getPath()
    {
      return $this->path;
    }

    public function getQuery()
    {
      return $this->query;
    }

    public function setQuery($query)
    {
      $this->query = $query;
    }

    public function addToQuery($key, $value)
    {
      if(strlen($this->query) > 0)
        $this->query .= '&';

      $this->query .= http_build_query(array($key => $value), '', '&');
    }

    protected function parseUri($uri)
    {
      // @TODO: Parse uri

      $this->uri = $uri;
    }


    public function getRelativeUri()
    {
      $uri = '';
      $uri .= $this->path;

      return $uri;
    }

    public function getRawAuthority()
    {
      $authority = $this->host;

      if($this->hasPort())
        $authority .= ':' . $this->port;

      return $authority;
    }

    public function getAbsoluteUri()
    {
      $uri = $this->scheme . '://' . $this->getRawAuthority();

      $uri .= $this->path;

      if(!empty($this->query))
        $uri .= '?' . $this->query;

      if(!empty($this->fragment))
        $uri .= '#' . $this->fragment;

      return $uri;
    }


    /**
     * Uses protected user info by default as per rfc3986-3.2.1
     * Uri::getAbsoluteUri() is available if plain-text password information is desirable.
     *
     * @return string
     */
    public function __toString()
    {
      $uri = $this->uri;

      if(!empty($this->query))
        $uri .= "?{$this->query}";

      return $uri;
    }
  }

?>