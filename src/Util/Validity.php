<?php

  namespace LibX\Util;

  /**
   * Class Validity
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Validity
  {
    protected $begin;
    protected $end;

    public function __construct(Datetime $begin, Datetime $end)
    {
      $this->begin = $begin;
      $this->end = $end;
    }

    public function getBegin()
    {
      return $this->begin;
    }

    public function getEnd()
    {
      return $this->end;
    }

    /**
     * Convert to array with mongo data types
     *
     * @param void
     * @return array
     */
    public function toMongo()
    {
      return $this->toArray();
    }

    /**
     * Convert to Array
     *
     * @param void
     * @return array
     */
    public function toArray()
    {
      $_event = array();
      $_event['begin'] = $this->getBegin()->getValue();
      $_event['end'] = $this->getEnd()->getValue();

      return $_event;
    }

    public static function fromStdClassApi($_event)
    {
      $begin = new Datetime($_event->begin);
      $end = new Datetime($_event->end);

      $event = new static($begin, $end);

      return $event;
    }

    /**
     * Create from StdClass
     *
     * @param StdClass $_event
     * @return Event
     */
    public static function fromStdClass($_event)
    {
      $begin = new Datetime($_event->begin);
      $end = new Datetime($_event->end);

      $event = new static($begin, $end);

      return $event;
    }
  }

?>