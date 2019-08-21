<?php

  namespace LibX\Dom\Document;

  // LibX dom
  use LibX\Dom\Document;

  use DOMNode;
  use DOMNodeList;
  
  use Exception;
  use InvalidArgumentException;
  
  /**
   * Handler
   *
   * Document manager/handler
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  abstract class Handler
  {
    protected $document;
    protected $node;

    /**
     * Handler constructor
     *
     * @param Document $document
     * @param DOMNode $node
     * @return Handler
     */
    protected function __construct(Document $document, DOMNode $node = null)
    {
      $this->document = $document;

      if(!is_null($node))
        $this->node = $node;
       else
        $this->node = $document->documentElement;
    }

    /**
     * Get node as value
     *
     * @param string $xquery
     * @return mixed
     */
    protected function getNodeValue($xquery)
    {
      $nodeList = $this->document->getXPath()->query($xquery, $this->node);

      if($nodeList->length == 0)
        throw new Exception(__METHOD__ . '; ' . $xquery . ' node is missing');

      // Return value of node
      return $this->getValue($nodeList->item(0));
    }

    /**
     * Get value
     *
     * @param DOMNode $node
     * @return mixed
     */
    protected function getValue(DOMNode $node)
    {
      // Init value
      $value = null;

      if(is_numeric($node->nodeValue))
        $value = $node->nodeValue;
      elseif(is_string($node->nodeValue))
        $value = utf8_decode($node->nodeValue);

      return $value;
    }

    /**
     * Get node
     *
     * @param string $xquery
     * @return DOMNode
     * @throws Exception
     */
    protected function getNode($xquery)
    {
      $nodeList = $this->document->getXPath()->query($xquery, $this->node);

      if($nodeList->length == 0)
        throw new Exception(__METHOD__ . '; ' . $xquery . ' node is missing');

      return $nodeList->item(0);
    }

    /**
     * Get nodelist
     *
     * @param string $xquery
     * @return DOMNodeList
     * @throws Exception
     */
    protected function getNodeList($xquery)
    {
      $nodeList = $this->document->getXPath()->query($xquery, $this->node);

      return $nodeList;
    }

    /**
     * Create a node
     *
     * @param string $name
     * @return DOMNode
     */
    protected function createNode($name, $value = null)
    {
      $node = $this->document->createElement($name, $value);

      return $node;
    }

    /**
     * Append node
     *
     * When not null
     * - XQuery => append node here
     * - Parent node => append node here
     * - Parent document => append node here
     *
     * @param DOMNode $node
     * @param string $xquery
     * @return DOMNode
     */
    protected function appendNode(DOMNode $node, $xquery = null)
    {
      // Determine parent node
      if(!is_null($xquery))
        $parentNode = $this->getNode($xquery);
      else if(!is_null($this->node))
        $parentNode = $this->node;
      else
        $parentNode = $this->document;

      $parentNode->appendChild($node);
    }

    /**
     * Append node after
     *
     * When not null
     * - XQuery => append node after here
     * - Parent node => append node after here
     * - Parent document => append node after here
     *
     * @param DOMNode $node
     * @param string $xquery
     * @param array $nodeNameList
     * @return DOMNode
     * @throws InvalidArgumentException
     */
    protected function appendNodeAfter(DOMNode $node, $xquery = null, $nodeNameList = array())
    {
      // Check if nodes is an array
      if(!is_array($nodeNameList))
        throw new InvalidArgumentException(__METHOD__ . '; Nodes should be an array');

      // Determine parent node
      if(!is_null($xquery))
        $parentNode = $this->getNode($xquery);
      else if(!is_null($this->node))
        $parentNode = $this->node;
      else
        $parentNode = $this->document;

      // Init child node (the one we are looking for)
      $childNode = null;

      // Iterate through existing childNodes
      if($parentNode->hasChildNodes())
      {
        // Get child nodes from parent
        $childNodes = $this->convertNodeListToArray($parentNode->childNodes);

        // Reverse the child nodes array
        $childNodes = array_reverse($childNodes);

        // Reset pointer
        reset($childNodes);

        while(current($childNodes) != null && is_null($childNode))
        {
          if(in_array(current($childNodes)->nodeName, $nodeNameList) || in_array(current($childNodes)->localName, $nodeNameList))
            $childNode = current($childNodes);

          // Next element
          next($childNodes);
        }
      }

      if(!is_null($childNode))
        $parentNode->insertBefore($node, $childNode);
      else
        $parentNode->appendChild($node);
    }

    /**
     * Append node before
     *
     * When not null
     * - XQuery => append node before here
     * - Parent node => append node before here
     * - Parent document => append node before here
     *
     * @param DOMNode $node
     * @param string $xquery
     * @param array $nodeNameList
     * @return DOMNode
     * @throws InvalidArgumentException
     */
    protected function appendNodeBefore(DOMNode $node, $xquery = null, $nodeNameList = array())
    {
      if(!is_array($nodeNameList))
        throw new InvalidArgumentException(__METHOD__ . '; Nodes should be an array');

      // Determine parent node
      if(!is_null($xquery))
        $parentNode = $this->getNode($xquery);
      else if(!is_null($this->node))
        $parentNode = $this->node;
      else
        $parentNode = $this->document;

      // Init child node (the one we are looking for)
      $childNode = null;

      // Iterate through existing childNodes
      if($parentNode->hasChildNodes())
      {
        // Get child nodes from parent
        $childNodes = $this->convertNodeListToArray($parentNode->childNodes);

        // Reset pointer
        reset($childNodes);

        while(current($childNodes) != null && is_null($childNode))
        {
          if(in_array(current($childNodes)->nodeName, $nodeNameList) || in_array(current($childNodes)->localName, $nodeNameList))
            $childNode = current($childNodes);

          // Next element
          next($childNodes);
        }
      }

      if(!is_null($childNode))
        $parentNode->insertBefore($node, $childNode);
      else
        $parentNode->appendChild($node);
    }

    /**
     * Convert a DOMNodeList to an array
     *
     * @param DOMNodeList $nodeList
     * @return array
     */
    private function convertNodeListToArray(DOMNodeList $nodeList)
    {
      $array = array();

      if(!is_null($nodeList) && $nodeList->length > 0)
      {
         foreach($nodeList as $node)
           array_push($array, $node);
      }

      return $array;
    }

    /**
     * Set node as value
     *
     * @param string $xquery
     * @param mixed $value
     * @return void
     */
    protected function setNodeValue($xquery, $value)
    {
      $nodeList = $this->document->getXPath()->query($xquery, $this->node);

      if($nodeList->length == 0)
        throw new Exception(__METHOD__ . '; ' . $xquery . ' node is missing');

      if(is_int($value))
        $nodeList->item(0)->nodeValue = $value;
      elseif(is_string($value))
        $nodeList->item(0)->nodeValue = utf8_encode($value);
      elseif(is_bool($value))
        $nodeList->item(0)->nodeValue = ($value ? 'true' : 'false');
    }

    /**
     * Get node value as object
     *
     * @param string $xquery
     * @param string $className
     * @return mixed
     */
    protected function getNodeValueAsObject($xquery, $className)
    {
      $nodeList = $this->document->getXPath()->query($xquery, $this->node);

      if($nodeList->length == 0)
        throw new Exception(__METHOD__ . '; ' . $xquery . ' node is missing');

      return new $className(utf8_decode($nodeList->item(0)->nodeValue));
    }

    /**
     * Get node as object
     *
     * @param string $xquery
     * @param string $className
     * @return mixed
     */
    protected function getNodeAsObject($xquery, $className)
    {
      $nodeList = $this->document->getXPath()->query($xquery, $this->node);

      if($nodeList->length == 0)
        throw new Exception(__METHOD__ . '; ' . $xquery . ' node is missing');

      return new $className($this->document, $nodeList->item(0));
    }

    /**
     * Check if node is present
     *
     * @param string $xquery
     * @return boolean
     */
    protected function hasNode($xquery)
    {
      $nodeList = $this->document->getXPath()->query($xquery, $this->node);

      return ($nodeList->length > 0);
    }

    /**
     * Get the internal document
     *
     * @param void
     * @return Document
     */
    public function getDocument()
    {
      return $this->document;
    }
  }

?>