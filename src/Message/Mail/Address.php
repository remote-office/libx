<?php

  namespace LibX\Message\Mail;

  use StdClass;

  /**
   * Class Address
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @vesion 1.0
   */
  class Address
  {
    protected $email;
    protected $name;

    public function __construct($mailbox, $domain, $name = null)
    {
      $this->setMailbox($mailbox);
      $this->setDomain($domain);

      if(!is_null($name))
        $this->setName($name);
    }

    public function getMailbox()
    {
      return $this->mailbox;
    }

    public function setMailbox($mailbox)
    {
      $this->mailbox = $mailbox;
    }

    public function getDomain()
    {
      return $this->domain;
    }

    public function setDomain($domain)
    {
      $this->domain = $domain;
    }

    public function getName()
    {
      return $this->name;
    }

    public function setName($name)
    {
      $this->name = $name;
    }

    public function hasName()
    {
      return !is_null($this->name);
    }

    public function toArray()
    {
      $_address = [];
      $_address['mailbox'] = $this->getMailbox();
      $_address['domain'] = $this->getDomain();

      if($this->hasName())
        $_address['name'] = $this->getName();

      return $_address;
    }

    public static function fromStdClass(StdClass $_address)
    {
      $mailbox = $_address->mailbox;
      $domain = $_address->domain;

      $address = new static($mailbox, $domain);

      if(isset($_address->name))
        $address->setName($_address->name);

      return $address;
    }
  }