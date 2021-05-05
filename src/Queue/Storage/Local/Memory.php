<?php

  namespace LibX\Queue\Storage\Local;

  use LibX\Queue\Storage\StorageInterface;
  use LibX\Queue\QueueableInterface;
  use LibX\Queue\Queue;

  class Memory implements StorageInterface
  {
    protected $array = [];

    public function enqueue(Queue $queue, $queueable)
    {
      return array_push($this->array, $queueable);
    }

    public function dequeue(Queue $queue)
    {
      return array_shift($this->array);
    }
  }

?>