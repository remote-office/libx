<?php

  namespace LibX\Dom;

  use DOMDocument;
  use DOMNode;
  use DOMXPath;

  /**
   * Document
   *
   * Extention of DOMDocument
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Document extends DOMDocument
  {
    protected $xpath;
    protected $namespaces;

    /**
     * Construct a new Document
     *
     * @param string $version
     * @param string $encoding
     * @return Document
     */
    public function __construct($version = '1.0', $encoding = 'UTF-8')
    {
      parent::__construct($version, $encoding);
    }

    /**
     * Get DOMXPath for this Document
     *
     * @return DOMXPath
     */
    public function getXPath()
    {
      if(!isset($this->xpath))
      {
        $this->xpath = new DOMXPath($this);

        if($this->documentElement->namespaceURI <> '')
          $this->xpath->registerNamespace('default', $this->documentElement->namespaceURI);

        /*foreach ($this->getNamespaces() as $prefix => $namespaceUri)
          $this->xpath->registerNamespace($prefix, $namespaceUri);*/
      }

      return $this->xpath;
    }

    /**
     * Get the list of namespaces of this Document
     *
     * @return array
     */
    private function getNamespaces()
    {
      $this->namespaces = array();

      $nodeList = $this->documentElement->getElementsByTagName('*');

      foreach($nodeList as $node)
      {
        if (strlen($node->prefix) && strlen($node->namespaceURI) && !in_array($node->prefix, $this->namespaces))
          $this->namespaces[$node->prefix] = $node->namespaceURI;
      }

      return $this->namespaces;
    }

    public function importDocument(Document $document, $prefix = null, $namespaceUri = null)
    {
      return $this->importDocumentNode($document->documentElement, $prefix, $namespaceUri);
    }

    public function importDocumentNode(DOMNode $node, $prefix = null, $namespaceUri = null)
    {
      if(!is_null($namespaceUri))
        $importedNode = $this->createElementNS($namespaceUri, $node->nodeName);
      else
        $importedNode = $this->createElement($node->nodeName);

      // Copy attributes
      foreach($node->attributes as $attribute)
        $importedNode->setAttribute($attribute->name, $attribute->value);

      // Import childnodes
      foreach($node->childNodes as $childNode)
      {
        if ($childNode->nodeType == XML_ELEMENT_NODE)
          $importedNode->appendChild($this->importDocumentNode($childNode, $prefix, $namespaceUri));
        else
          $importedNode->appendChild($this->importNode($childNode, true));
      }

      return $importedNode;
    }

    public function exportDocument(DOMNode $node, $prefix = null, $namespaceUri = null)
    {
      // Create a new instance of Document
      $document = new Document();

      if(!is_null($namespaceUri))
      {
        $importNodes = $document->importDocumentNode($node, $prefix, $namespaceUri);
        $document->appendChild($importNodes);
      }
      else
      {
        // Import the requested node tree from the current document
        $importNodes = $document->importNode($node, true);

        // Append the imported nodes into the new LibXDocument
        $document->appendChild($importNodes);
      }

      return $document;
    }

    /**
     * Convert object into string
     *
     * @param void
     * @return string
     */
    public function __toString()
    {
      return $this->saveXML();
    }
  }

?>