<?php

  namespace LibX\Message\Mail;

  use StdClass;

  /**
   * Class Content
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @vesion 1.0
   */
  class Content
  {
    protected $text;
    protected $html;

    public function __construct($text, $html = null)
    {
      $this->setText($text);

      if(!is_null($html))
        $this->setHtml($html);
    }

    public function getText()
    {
      return $this->text;
    }

    public function setText($text)
    {
      $this->text = $text;
    }

    public function getHtml()
    {
      return $this->html;
    }

    public function setHtml($html)
    {
      $this->html = $html;
    }

    public function hasHtml()
    {
      return !is_null($this->html);
    }

    public function toArray()
    {
      $_content = [];
      $_content['text'] = $this->getText();

      if($this->hasHtml())
        $_content['html'] = $this->getHtml();

      return $_content;
    }

    public static function fromStdClass(StdClass $_content)
    {
      $text = $_content->text;

      $content = new static($text);

      if(isset($_content->html))
        $content->setHtml($_content->html);

      return $content;
    }
  }