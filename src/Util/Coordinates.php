<?php

  namespace LibX\Util;

  /**
   * Class Coordinates
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Coordinates extends Point
  {
    public function __construct($latitude, $longitude)
    {
      parent::__construct($latitude, $longitude);
    }

    public function getLatitude()
    {
      return $this->getX();
    }

    public function getLongitude()
    {
      return $this->getY();
    }

    public static function fromStdClass($_coordinates)
    {
      $latitude = $_coordinates->latitude;
      $longitude = $_coordinates->longitude;

      $coordinates = new static($latitude, $longitude);

      return $coordinates;
    }

    public function toArray()
    {
      $_coordinates = [];
      $_coordinates['latitude'] = $this->getLatitude();
      $_coordinates['longitude'] = $this->getLongitude();

      return $_coordinates;
    }
  }

?>