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
      $this->setStorage($storage);
    }

    public function setStorage(StorageInterface $storage)
    {
      $this->storage = $storage;
    }
  }

?>