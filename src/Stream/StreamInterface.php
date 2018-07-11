<?php

  namespace LibX\Stream;

  interface StreamInterface
  {
    public function isReadable();
    public function isWritable();
    public function isSeekable();

    public function read($length);
    public function write($string);
    public function rewind();

    public function getContents();

    public function __toString();
  }

?>