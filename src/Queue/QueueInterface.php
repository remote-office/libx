<?php

  namespace LibX\Queue;

  interface QueueInterface
  {
    public function enqueue(QueueableInterface $queueable);
    public function dequeue();
  }

?>