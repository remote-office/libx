<?php

  namespace LibX\External\SimplePay;

  use LibX\Util\Stack;

  /**
   * ProviderStack
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class ProviderStack extends Stack
  {
    /**
     * Push a Provider on the ProviderStack
     *
     * @param Provider $provider
     * @return void
     */
    public function push(Provider $provider)
    {
      array_push($this->array, $provider);
    }

    /**
     * Pop a Provider from the ProviderStack
     *
     * @param void
     * @return Provider
     */
    public function pop()
    {
      return array_pop($this->array);
    }
  }

?>