<?php

  namespace LibX\Util;

  /**
   * Class UuidStack
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class UuidStack extends Stack
  {
    public function push(Uuid $uuid)
    {
      return array_push($this->array, $uuid);
    }

    public function pop()
    {
      return array_pop($this->array);
    }
  }

?>