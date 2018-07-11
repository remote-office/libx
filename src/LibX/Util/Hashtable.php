<?php

  namespace LibX\Util;

  /**
   * Class Hashtable
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Hashtable extends Stack
  {
    /**
     * Set a value by key
     *
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
      $this->array[$key] = $value;
    }

    /**
     * Get a value by key
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
      if(isset($this->array[$key]))
        return $this->array[$key];
    }

    /**
     * Delete a value by key
     *
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
       if(isset($this->array[$key]))
        unset($this->array[$key]);
    }
  }

?>