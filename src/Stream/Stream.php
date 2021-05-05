<?php

  namespace LibX\Stream;

  use InvalidArgumentException;
  use RuntimeException;
  
  class Stream implements StreamInterface
  {
    protected $stream;

    public function __construct($stream)
    {
      if(is_resource($stream) === false)
        throw new InvalidArgumentException('Stream must be a valid PHP resource');

      $this->stream = $stream;
    }

    public function isReadable()
    {
      return true;
    }

    public function isWritable()
    {
      return true;
    }

    public function isSeekable()
    {
      return true;
    }

    public function read($length)
    {
      if(!$this->isReadable() || ($data = fread($this->stream, $length)) === false)
        throw new \RuntimeException('Could not read from stream');

      return $data;
    }

    public function write($string)
    {
      if(!$this->isWritable() || ($written = fwrite($this->stream, $string)) === false)
        throw new RuntimeException('Could not write to stream');

      return $written;
    }

    public function rewind()
    {
      if(!$this->isSeekable() || rewind($this->stream) === false)
        throw new RuntimeException('Could not rewind stream');
    }

    /**
     * Returns the remaining contents in a string
     *
     * @return string
     *
     * @throws RuntimeException if unable to read or an error occurs while reading.
     */
    public function getContents()
    {
      if(!$this->isReadable() || ($contents = stream_get_contents($this->stream)) === false)
        throw new RuntimeException('Could not get contents of stream');

      return $contents;
    }

    public function __toString()
    {
      try
      {
        // Rewind
        $this->rewind();
        // Get contents
        return $this->getContents();
      }
      catch(RuntimeException $e)
      {
        return '';
      }
    }
  }

?>