<?php

  namespace LibX\Util;

  /**
   * Class Polygon
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Polygon
  {
    protected $points;

    public function __construct(PointStack $points)
    {
      $this->points = $points;
    }

    public function getPoints()
    {
      return $this->points;
    }

    public function setPoints(PointStack $points)
    {
      $this->points = $points;
    }

    public function addPoint(Point $point)
    {
      $this->points->push($point);
    }
  }

?>