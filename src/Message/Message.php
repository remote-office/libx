<?php

  namespace LibX\Message;

  use LibX\Util\Uuid;

  use LibX\Queue\QueueableInterface;

  use StdClass;

  /**
   * Class Message
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  abstract class Message implements QueueableInterface
  {
    protected $uuid;
    protected $class;

    //protected $sender;
    //protected $recipient;
    //protected $content;

    protected function __construct(Uuid $uuid, $class)
    {
      $this->uuid = $uuid;
      $this->class = $class;
    }

    public function getUuid()
    {
      return $this->uuid;
    }

    public function getClass()
    {
      return $this->class;
    }

    public abstract function getSender();
    public abstract function getRecipient();
    public abstract function getContent();

    /**
     * QueueableInterface
     */
    public abstract function toJson();

    public static function fromStdClass(StdClass $_message)
    {
      // Get the type
      $class = $_message->class;

      // Get the class
      $className = '\\LibX\\Message\\' . ucfirst($class) . '\\' . ucfirst($class);

      return $className::fromStdClass($_message);
    }
  }

?>