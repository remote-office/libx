<?php

  namespace LibX\Util;

  use Iterator;
  use ArrayAccess;

	/**
	 * Stack
	 *
	 * Extention of Iterator
	 *
	 * @author David Betgen <d.betgen@remote-office.nl>
	 * @version 1.0
	 */
	class Stack implements Iterator, ArrayAccess
	{
	  protected $array = array();

	  /**
	   * Move forward to next element, and return it
	   *
	   * @param void
	   * @return mixed
	   */
	  public function next()
	  {
	    return next($this->array);
	  }

	  /**
	   * Move backward to previous element, and return it
	   *
	   * @param void
	   * @return mixed
	   */
	  public function prev()
	  {
	    return prev($this->array);
	  }

	  /**
	   * Get the current element of the array
	   *
	   * @param void
	   * @return mixed
	   */
	  public function current()
	  {
	    return current($this->array);
	  }

	  /**
	   * Get the key of the current element of the array
	   *
	   * @param void
	   * @return mixed
	   */
	  public function key()
	  {
	    return key($this->array);
	  }

	  /**
	   * Check if there is a current element after calls to rewind(), next() and forward().
	   *
	   * @param void
	   * @return boolean
	   */
	  public function valid()
	  {
	    return ($this->current() !== false);
	  }

	  /**
	   * Reset the array pointer
	   *
	   * @param void
	   * @return void
	   */
	  public function rewind()
	  {
	    reset($this->array);
	  }

	  /**
	   * Reset the array pointer to the end of the array
	   *
	   * @param void
	   * @return void
	   */
	  public function forward()
	  {
	  	end($this->array);
	  }

	  /**
	   * Get first element of the array without moving the pointer
	   *
	   * @param void
	   * @return mixed
	   */
	  public function first()
	  {
	  	$stack = clone($this);
	  	$stack->rewind();

	  	return $stack->current();
	  }

	  /**
	   * Get last element of the array without moving the pointer
	   *
	   * @param void
	   * @return mixed
	   */
	  public function last()
	  {
	  	$stack = clone($this);
	  	$stack->forward();

	  	return $stack->current();
	  }

	  /**
		 * Get the size of this Stack
		 *
		 * @param void
		 * @return integer the size of this Stack
		 */
		public function sizeOf()
		{
			return count($this->array);
		}

	  /**
		 * Get array of this Stack
		 *
		 * @param void
		 * @return array
		 */
		public function toArray()
		{
			return $this->array;
		}

		/********************************************************************************
     * ArrayAccess interface
     *******************************************************************************/

    /**
     * Does this collection have a given key?
     *
     * @param  string $key The data key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
			return array_key_exists($key, $this->array);
    }

    /**
     * Get collection item for key
     *
     * @param string $key The data key
     *
     * @return mixed The key's value, or the default value
     */
    public function offsetGet($key)
    {
      return $this->array[$key];
    }

    /**
     * Set collection item
     *
     * @param string $key   The data key
     * @param mixed  $value The data value
     */
    public function offsetSet($key, $value)
    {
      $this->array[$key] = $value;
    }

    /**
     * Remove item from collection
     *
     * @param string $key The data key
     */
    public function offsetUnset($key)
    {
    	unset($this->array[$key]);
    }
	}

?>