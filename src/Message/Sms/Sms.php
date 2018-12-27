<?php

  namespace LibX\Message\Sms;

  use LibX\Util\Uuid;
  use LibX\Message\Message;


  use StdClass;

  /**
   * Class Sms
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @vesion 1.0
   */
  class Sms extends Message
  {
    protected $uuid;
    protected $sender;
    protected $recipient;
    protected $subject;
    protected $content;

    public function __construct(Uuid $uuid, $sender, $recipient, $content)
    {
      parent::__construct($uuid, 'sms');

      $this->setSender($sender);
      $this->setRecipient($recipient);
      $this->setContent($content);
    }

    public function getSender()
    {
      return $this->sender;
    }

    public function setSender($sender)
    {
      $this->sender = $sender;
    }

    public function getRecipient()
    {
      return $this->recipient;
    }

    public function setRecipient($recipient)
    {
      $this->recipient = $recipient;
    }

    public function getContent()
    {
      return $this->content;
    }

    public function setContent($content)
    {
      $this->content = $content;
    }

    public function toArray()
    {
      $_message = [];
      $_message['uuid'] = $this->getUuid()->getValue();
      $_message['class'] = $this->getClass();
      $_message['sender'] = $this->getSender();
      $_message['recipient'] = $this->getRecipient();
      $_message['content'] = $this->getContent();

      return $_message;
    }

    static public function fromStdClass(StdClass $_message)
    {
      $uuid = new Uuid($_message->uuid);
      //$type = $_message->type;
      $sender = $_message->sender;
      $recipient = $_message->recipient;
      $content = $_message->content;

      $message = new static($uuid, $sender, $recipient, $content);

      return $message;
    }

    /**
     * QueueableInterface
     *
     * @return string
     */
    public function toJson()
    {
      return json_encode($this->toArray());
    }
  }