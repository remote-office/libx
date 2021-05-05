<?php

  namespace LibX\Queue;

  interface QueueInterface
  {
    public function enqueue($queueable);
    public function dequeue();
  }

?>