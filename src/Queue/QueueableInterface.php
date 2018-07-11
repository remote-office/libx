<?php

  namespace LibX\Queue;

  interface QueueableInterface
  {
    /**
     * Convert object to JSON string
     *
     * @param void
     * @return string
     */
    public function toJson();
  }

?>