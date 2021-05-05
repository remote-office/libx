<?php

  namespace LibX\Util;

  /**
   * DatetimeWithTimezone
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class DatetimeWithTimezone extends Datetime
  {
    /**
     * Construct a new DatetimeWithTimezone
     *
     * @param string $datetime
     * @return DatetimeWithTimezone
     */
    public function __construct($datetime = null)
    {
      // @todo: ADD REAL TIMEZONE CODE
      if(!is_null($datetime))
        $datetime = date('Y-m-d H:i:s', strtotime($datetime));

      parent::__construct($datetime);
    }

    /**
     * Get the value of this DatetimeWithTimezone as an ISO string
     *
     * @param void
     * @return string
     */
    public function getValue()
    {
    }

    /**
     * Validate if a string is a datetime with timezone
     *
     * @param string $time
     * @return boolean true if string is a datetime with timezone, false otherwise
     */
    static public function validate($datetime)
    {
    }
  }

?>