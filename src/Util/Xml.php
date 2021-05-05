<?php

  namespace LibX\Util;

  use XMLWriter;
  use StdClass;
  
  /**
   * Xml
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Xml
  {
    static public function fromJson($json)
    {
      // Create a XmlWriter
      $xmlWriter = new XmlWriter();
      
      // Open a XML document
      $xmlWriter->openMemory();
      $xmlWriter->startDocument('1.0', 'UTF-8');
      $xmlWriter->setIndent(true);
      
      // Convert json to object
      $object = json_decode($json);
      
      // Convert
      Xml::fromObject($xmlWriter, $object);
      
      // Ouput XML document (memory) to string
      $xml = $xmlWriter->outputMemory(true);
      
      return $xml;
    }
    
    
    /**
     * Convert object into a XML string
     *
     * @param XMLWriter $xml
     * @param StdClass $data
     * @return void
     */
    static protected function fromObject(XMLWriter $xmlWriter, $object)
    {
      foreach($object as $key => $value)
      {
        if(is_object($value) || is_array($value))
        {
          if(is_object($value))
          {
            if($key == '@attributes')
            {
              foreach($value as $k => $v)
                $xmlWriter->writeAttribute($k, $v);
            }
            else if($key == '@text')
            {
              $xmlWriter->text($value);
            }
            else
            {
              // Start element
              $xmlWriter->startElement($key);
              
              // Recursive call
              Xml::fromObject($xmlWriter, $value);
              
              // End element
              $xmlWriter->endElement();
            }
          }
          else
          {
            Xml::fromArray($xmlWriter, $key, $value);
          }
        }
        elseif(is_string($value) || is_numeric($value) || is_null($value))
        {
          if($key == '@attributes')
          {
            foreach($value as $k => $v)
              $xmlWriter->writeAttribute($k, $v);
          }
          else if($key == '@text')
          {
            $xmlWriter->text($value);
          }
          else
          {
            $xmlWriter->writeElement($key, $value);
          }
        }
      }
    }
    
    /**
     * Convert array into a XML string
     *
     * @param XMLWriter $xml
     * @param string $keyParent
     * @param StdClass $data
     * @return void
     */
    static protected function fromArray(XMLWriter $xmlWriter, $keyParent, $data)
    {
      // Flag to keep track of element start and end
      //$element = false;
      
      foreach($data as $key => $value)
      {
        if(is_string($value))
        {
          $xmlWriter->writeElement($keyParent, $value);
        }
        else
        {
          if(is_numeric($key))// && !$element)
            $element = $xmlWriter->startElement($keyParent);
            
          //if(is_object($value) || is_array($value) || is_null($value))
          if(is_object($value) || is_array($value))
          {
            if(is_object($value))
              Xml::fromObject($xmlWriter, $value);
            else
              Xml::fromArray($xmlWriter, $key, $value);
          }
          
          //if($element)
          if(is_numeric($key))
            $xmlWriter->endElement();
        }
      }
    }
  }
  
?>