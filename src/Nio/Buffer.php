<?php

  namespace LibX\Nio;
  
  /**
   * Class Buffer
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @package libx.nio
   * @version 1.0
   */
  abstract class Buffer
  {
    /**
     * @var int The size of the buffer
     */
    protected $capacity;

    /**
     * @var int The limit to which the buffer may be filled
     */
    protected $limit;

    /**
     * @var int The current position of the read pointer
     */
    protected $position;

    /**
     * Clears the state of this byte buffer object
     *
     * Sets the <var>limit</var> to the <var>capacity</var> of the buffer and
     * resets the <var>position</var>.
     */
    public function clear()
    {
      $this->limit = $this->capacity;
      $this->position = 0;
    }

    /**
     * Sets the <var>limit</var> to the current <var>position</var> before
     * resetting the <var>position</var>.
     *
     * @return ByteBuffer This byte buffer
     */
    public function flip()
    {
      $this->limit = $this->position;
      $this->position = 0;

      return $this;
    }

    /**
     * Sets or returns the <var>limit</var> of the buffer
     *
     * @param int $newLimit Sets the buffer's <var>limit</var> to this value
     * @return int If no new <var>limit</var> value is given, the current value
     */
    public function limit($newLimit = null)
    {
      if($newLimit == null)
        return $this->limit;

      $this->limit = $newLimit;
      return null;
    }

    /**
     * Returns the current <var>position</var> of the buffer
     *
     * @return int The current <var>position</var> of the buffer
     */
    public function position()
    {
      return $this->position;
    }

    /**
     * Returns the remaining number of byte from the current
     * <var>position</var> to the <var>limit</var> of the buffer
     *
     * @return int The number of bytes remaining in the buffer
     */
    public function remaining()
    {
      return $this->limit - $this->position;
    }

    /**
     * Resets the <var>position</var> of this buffer
     *
     * @return ByteBuffer This byte buffer
     */
    public function rewind()
    {
      $this->position = 0;

      return $this;
    }
  }

?>