<?php

  namespace LibX\Queue\Storage;

  use LibX\Queue\QueueableInterface;
  use LibX\Queue\Queue;

  interface StorageInterface
  {
    public function enqueue(Queue $queue, QueueableInterface $queueable);
    public function dequeue(Queue $queue);
  }

?>