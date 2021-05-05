<?php 

  namespace LibX\Sepa;
  
  class Document
  {
    public function __construct()
    {
      
    }
    
    public function addDirectDebitTransaction()
    {
      
    }
    
    public function toXml()
    {
      // Create a document
      $document = new \LibX\Dom\Document();
      
      // Create a builder
      $builder = new Builder($document);
      
      $documentNode = $builder->createNode('Document');
      $builder->appendNode($documentNode);
      
      $customerNode = $builder->createNode('CstmrDrctDbtInitn');
      $builder->appendNode($customerNode, '//Document');
      
      
      echo $document->saveXML();
      
    }
  }

?>