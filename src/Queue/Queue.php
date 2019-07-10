<?php

  namespace LibX\Queue;

  use LibX\Queue\Storage\StorageInterface;
  use LibX\Queue\CredentialsInterface;

  /**
   * Class Queue
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Queue implements QueueInterface
  {
    protected $identifier;
    protected $storage;
    protected $credentials;

    /**
     * Construct a queue
     *
     * @param string $indentifier
     * @param StorageInterface $storage
     * @param CredentialsInterface $credentials
     *
     * @return QueueInterface
     */
    public function __construct($indentifier, StorageInterface $storage, CredentialsInterface $credentials = null)
    {
      $this->identifier = $indentifier;
      $this->storage = $storage;
      $this->credentials = $credentials;
    }

    public function identify()
    {
      return $this->identifier;
    }

    public function enqueue($queueable)
    {
      return $this->storage->enqueue($this, $queueable);
    }

    public function dequeue()
    {
      return $this->storage->dequeue($this);
    }
  }

?>