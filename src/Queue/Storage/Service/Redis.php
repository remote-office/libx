<?php

  namespace LibX\Queue\Storage\Service;

  use LibX\Queue\Storage\StorageInterface;
  use LibX\Queue\QueueableInterface;
  use LibX\Queue\Queue;

  class Redis implements StorageInterface
  {
    public function enqueue(Queue $queue, QueueableInterface $queueable)
    {

    }

    public function dequeue(Queue $queue)
    {

    }
  }

?>