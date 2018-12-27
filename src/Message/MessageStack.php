<?php

  namespace LibX\Message;

  use LibX\Util\Stack;

  /**
   * MessageStack
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class MessageStack extends Stack
  {
    /**
     * Push a Message on the MessageStack
     *
     * @param Message $message
     * @return void
     */
    public function push(Message $message)
    {
      array_push($this->array, $message);
    }

    /**
     * Pop a Message from the MessageStack
     *
     * @param void
     * @return Message
     */
    public function pop()
    {
      return array_pop($this->array);
    }
  }

?>