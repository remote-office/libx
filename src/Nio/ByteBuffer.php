<?php
  
  namespace LibX\Nio;
  
  /**
   * Class ByteBuffer
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @package libx.nio
   * @version 1.0
   */
  class ByteBuffer extends Buffer
  {
    /**
     * @var string The string holding the buffer's bytes
     */
    protected $byteArray;


    /**
     * Allocates a string with the specified amount of bytes wrapped into a
     * byte buffer object
     *
     * @param int $length The size of the byte buffer
     * @return ByteBuffer The new byte buffer object
     */
    public static function allocate($length)
    {
      return new ByteBuffer(str_repeat("\0", $length));
    }

    /**
     * Wraps an existing string into a byte buffer object
     *
     * @param string $byteArray The string to encapsulate into the byte buffer
     * @return ByteBuffer The new ByteBuffer object
     */
    public static function wrap($byteArray)
    {
      return new ByteBuffer($byteArray);
    }

    /**
     * Creates a new byte buffer instance
     *
     * @param string $byteArray The string to encapsulate into the
     *        byte buffer
     */
    public function __construct($byteArray)
    {
      $this->byteArray = $byteArray;
      $this->capacity = strlen($byteArray);
      $this->limit = $this->capacity;
      $this->position = 0;
    }

    /**
     * Reads the specified amount of bytes from the current <var>position</var>
     * of the byte buffer
     *
     * @param int $length The amount of bytes to read from the buffer or
     *        <var>null</var> if everything up to <var>limit</var> should be
     *        read
     * @return string The data read from the buffer
     * @throws BufferUnderflowException if the buffer does not contain $length
     *         or more bytes after the current position
     */
    public function get($length = null)
    {
      if($length > $this->remaining())
        throw new BufferUnderFlowException();

      if($length === null)
        $length = $this->limit - $this->position;

      $data = substr($this->byteArray, $this->position, $length);
      $this->position += $length;

      return $data;
    }

    /**
     * Reads a single byte from the buffer
     *
     * @return int The byte at the current position
     */
    public function getByte()
    {
      return ord($this->get(1));
    }

    /**
     * Reads a floating point number from the buffer
     *
     * @return float The floating point number, i.e. four bytes converted to a
     *         <var>float</var> read at the current position
     */
    public function getFloat()
    {
      $data = unpack('f', $this->get(4));

      return $data[1];
    }

    /**
     * Reads a long integer from the buffer
     *
     * @return int The long integer, i.e. four bytes converted to an
     *         <var>int</var> read at the current position
     */
    public function getLong()
    {
      $data = unpack('l', $this->get(4));

      return $data[1];
    }

    /**
     * Reads a short integer from the buffer
     *
     * @return int The short integer, i.e. two bytes converted to an
     *         <var>int</var> read at the current position
     */
    public function getShort()
    {
      $data = unpack('v', $this->get(2));

      return $data[1];
    }

    /**
     * Reads a zero-byte terminated string from the current position of the
     * byte buffer
     *
     * This reads the buffer up until the first occurance of a zero-byte or the
     * end of the buffer. The zero-byte is not included in the returned string.
     *
     * @return string The zero-byte terminated string read from the byte stream
     */
    public function getString()
    {
      $zeroByteIndex = strpos($this->byteArray, "\0", $this->position);

      if($zeroByteIndex === false)
      {
        return '';
      }
      else
      {
        $dataString = $this->get($zeroByteIndex - $this->position);
        $this->position ++;

        return $dataString;
      }
    }

    /**
     * Reads an unsigned long integer from the buffer
     *
     * @return int The long integer, i.e. four bytes converted to an unsigned
     *         <var>float</var> read at the current position
     */
    public function getUnsignedLong()
    {
      $data = unpack('V', $this->get(4));

      return $data[1];
    }

    /**
     * Replaces the contents of the byte buffer with the bytes from the source
     * string beginning at the current <var>position</var>
     *
     * @param string $sourceByteArray The string to take bytes from
     * @return ByteBuffer This byte buffer
     */
    public function put($sourceByteArray)
    {
      $newPosition = min($this->remaining(), strlen($sourceByteArray));
      $this->byteArray = substr_replace($this->byteArray, $sourceByteArray, $this->position, $newPosition);
      $this->position = $newPosition;

      return $this;
    }

    /**
     * Returns the string wrapped into this byte buffer object
     *
     * @return string The string encapsulated in this byte buffer
     */
    public function _array()
    {
      return $this->byteArray;
    }
  }

?>