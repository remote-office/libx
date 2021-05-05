<?php

  namespace LibX\Util;

  /**
   * Class PointStack
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class PointStack extends Stack
  {
    public function push(Point $point)
    {
      return array_push($this->array, $point);
    }

    public function pop()
    {
      return array_pop($this->array);
    }
  }

?>