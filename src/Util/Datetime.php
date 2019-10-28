<?php

  namespace LibX\Util;

  /**
   * Datetime
   *
   * Class for handling date and time formats, uses ISO 8601 as format
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Datetime
  {
    protected $date;
    protected $time;

    /**
     * Construct a new Datetime
     *
     * @param string $datetime
     * @return Datetime
     */
    public function __construct($datetime = null)
    {
      if(!is_null($datetime))
      {
        // Break into parts
        $parts = preg_split('/[T ]/', $datetime);

        $this->date = new Date($parts[0]);
        $this->time = new Time($parts[1]);
      }
      else
      {
        $this->date = new Date();
        $this->time = new Time();
      }
    }

    /**
     * Get the value of this Datetime as an ISO string
     *
     * @param void
     * @return string
     */
    public function getValue()
    {
      return $this->date->getValue() . 'T' . $this->time->getValue();
    }

    /**
     * Generate a Datetime
     *
     * @param void
     * @return string
     */
    static public function generate($datetime = null)
    {
      $datetime = new static($datetime);

      return $datetime->getValue();
    }

    /**
     * Get the Date of this Datetime
     *
     * @param void
     * @return Date
     */
    public function getDate()
    {
      return $this->date;
    }

    /**
     * Get the Time of this Datetime
     *
     * @param void
     * @return Time
     */
    public function getTime()
    {
      return $this->time;
    }

    /**
     * Get the timestamp of this Datetime
     *
     * @param void
     * @return integer
     */
    public function getTimestamp()
    {
      return strtotime($this->getValue());
    }

    /**
     * Validate if a string is a datetime
     *
     * @param string $time
     * @return boolean true if string is a datetime, false otherwise
     */
    static public function validate($datetime)
    {
      // Break into parts
      $parts = preg_split('/[T ]/', $datetime);

      return Date::validate($parts[0]) && Time::validate($parts[1]);
    }
  }



  class DatetimeRange
  {
    public function __construct(Datetime $start, Datetime $end)
    {
    }
  }

  class DateRange
  {
    public function __construct(Date $start, Date $end)
    {
    }
  }

  class TimeRange
  {
    public function __construct(Time $start, Time $end)
    {
    }
  }

?>