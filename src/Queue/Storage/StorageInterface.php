<?php

  namespace LibX\Queue\Storage;

  use LibX\Queue\QueueableInterface;
  use LibX\Queue\Queue;

  interface StorageInterface
  {
    public function enqueue(Queue $queue, $queueable);
    public function dequeue(Queue $queue);
  }

?>