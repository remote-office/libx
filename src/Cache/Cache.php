<?php

  namespace LibX\Cache;

  use LibX\Cache\Storage\StorageInterface;

  class Cache
  {
    protected $storage;

    /**
     * Construct a Cache
     *
     * @param StorageInterface $storage
     * @return Cache
     */
    public function __construct(StorageInterface $storage)
    {
      $this->storage = $storage;
    }

    public function retrieve($key)
    {
      return $this->storage->retrieve($key);
    }

    public function store($key, $value)
    {
      return $this->storage->store($key, $value);
    }

    public function remove($key)
    {
      return $this->storage->remove($key);
    }

    public function has($key)
    {
      return $this->storage->has($key);
    }
  }

?>