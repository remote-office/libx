<?php

  namespace LibX\Cache\Storage;

  interface StorageInterface
  {
    public function retrieve($key);
    public function store($key, $value);
    public function has($key);
    public function remove($key);
  }

?>