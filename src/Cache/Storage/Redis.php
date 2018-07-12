<?php

  namespace LibX\Cache\Storage;

  class Redis implements StorageInterface
  {
    protected $redis;

    /**
     * Construct a Redis
     *
     * @param void
     * @return Redis
     */
    protected function __construct($host, $post)
    {
      // Create a new Redis client
      $this->redis = new Redis();
      // Connect to Redis server
      $this->redis->connect($host, $post);
    }

    /**
     * Retrieve value from redis server
     *
     * @param string $key
     * @return string
     */
    public function retrieve($key)
    {
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
      // Get value by key
      $value = $this->redis->get($key);

      return ($value !== false ? true : false);
    }
  }

?>
