<?php

  namespace LibX\Message\Mail;

  use LibX\Util\Uuid;
  use LibX\Message\Message;


  use StdClass;

  /**
   * Class Mail
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @vesion 1.0
   */
  class Mail extends Message
  {
    protected $uuid;
    protected $sender;
    protected $recipient;
    protected $subject;
    protected $content;

    public function __construct(Uuid $uuid, Address $sender, Address $recipient, $subject, Content $content)
    {
      parent::__construct($uuid, 'mail');

      $this->setSender($sender);
      $this->setRecipient($recipient);
      $this->setSubject($subject);
      $this->setContent($content);
    }

    public function getSender()
    {
      return $this->sender;
    }

    public function setSender(Address $sender)
    {
      $this->sender = $sender;
    }

    public function getRecipient()
    {
      return $this->recipient;
    }

    public function setRecipient(Address $recipient)
    {
      $this->recipient = $recipient;
    }

    public function getSubject()
    {
      return $this->subject;
    }

    public function setSubject($subject)
    {
      $this->subject = $subject;
    }

    public function getContent()
    {
      return $this->content;
    }

    public function setContent(Content $content)
    {
      $this->content = $content;
    }

    public function toArray()
    {
      $_message = [];
      $_message['uuid'] = $this->getUuid()->getValue();
      $_message['class'] = $this->getClass();
      $_message['sender'] = $this->getSender()->toArray();
      $_message['recipient'] = $this->getRecipient()->toArray();
      $_message['subject'] = $this->getSubject();
      $_message['content'] = $this->getContent()->toArray();

      return $_message;
    }

    static public function fromStdClass(StdClass $_message)
    {
      $uuid = new Uuid($_message->uuid);
      $sender = Address::fromStdClass($_message->sender);
      $recipient = Address::fromStdClass($_message->recipient);
      $subject = $_message->subject;
      $content = Content::fromStdClass($_message->content);

      $message = new static($uuid, $sender, $recipient, $subject, $content);

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