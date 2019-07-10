<?php

  namespace LibX\Cache\Storage;

  class Redis implements StorageInterface
  {
    protected $host;
    protected $port;

    protected $redis;

    /**
     * Construct a Redis
     *
     * @param void
     * @return Redis
     */
    public function __construct($host, $port)
    {
      $this->host = $host;
      $this->port = $port;

      // Create a new Redis client
      $this->redis = new Redis();
    }

    /**
     * Connect to a redis server
     *
     * @param void
     * @return void
     * @throws \Exception
     */
    public function connect()
    {
      // Connect to Redis server
      if($this->redis->connect($this->host, $this->port) === false)
        throw new \Exception('Could not connect to redis server on host "' . $this->host . ':' . $this->port . '"');
    }

    /**
     * Retrieve value from redis server
     *
     * @param string $key
     * @return string
     */
    public function retrieve($key)
    {
      if(!$this->redis->isConnected())
        $this->connect();

      // Get value by key
      $value = $this->redis->get($key);

      if($value === false)
        return null;

      return $value;
    }

    /**
     * Store a value by key from redis server
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function store($key, $value)
    {
      if(!$this->redis->isConnected())
        $this->connect();

      // Set key
      $this->redis->set($key, $value);
    }

    /**
     * Remove a key from redis server
     *
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
      if(!$this->redis->isConnected())
        $this->connect();

      // Delete key
      $this->redis->delete($key);
    }

    /**
     * Check is key is present in redis server
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
      if(!$this->redis->isConnected())
        $this->connect();

      // Get value by key
      $value = $this->redis->get($key);

      return ($value !== false ? true : false);
    }
  }

?>
