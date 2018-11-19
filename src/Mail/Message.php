<?php

  namespace LibX\Mail;

  use LibX\Util\Uuid;

  use LibX\Mail\Message\Content;

  use StdClass;

  /**
   * Class Message
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @vesion 1.0
   */
  class Message
  {
    protected $uuid;
    protected $sender;
    protected $recipient;
    protected $subject;
    protected $content;

    public function __construct(Uuid $uuid, Address $sender, Address $recipient, $subject, Content $content)
    {
      $this->setUuid($uuid);
      $this->setSender($sender);
      $this->setRecipient($recipient);
      $this->setSubject($subject);
      $this->setContent($content);
    }

    public function getUuid()
    {
      return $this->uuid;
    }

    public function setUuid(Uuid $uuid)
    {
      $this->uuid = $uuid;
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
      $_message['sender'] = $this->getSender()->toArray();
      $_message['recipient'] = $this->getRecipient()->toArray();
      $_message['subject'] = $this->getSubject();
      $_message['content'] = $this->getContent()->toArray();

      return $_message;
    }

    static public function fromStdClass(StdClass $_message)
    {
      $uuid = new Uuid($data->Uuid);
      $sender = Address::fromStdClass($data->Sender->Address);
      $recipient = Address::fromStdClass($data->Recipient->Address);
      $subject = $data->Subject;
      $content = Content::fromStdClass($data->Content->Text);

      $message = new static($uuid, $sender, $recipient, $subject, $content);

      return $message;
    }
  }