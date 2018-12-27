<?php 

  namespace LibX\Sepa;

  use LibX\Dom\Document\Handler;
    
  class Builder extends \LibX\Dom\Document\Handler
  {
    public function __construct()
    {      
      parent::__construct(new \LibX\Dom\Document(), null);
    }
    
    public function generateXml(Sepa $sepa)
    {
      $documentNode = $this->createNode('Document');
      $this->appendNode($documentNode);
      
      $customerNode = $this->createNode('CstmrDrctDbtInitn');
      $this->appendNode($customerNode, '//Document');
      
      $groupHeaderNode = $this->createNode('GrpHdr');
      $this->appendNode($groupHeaderNode, '//Document/CstmrDrctDbtInitn');
      
      $this->appendNode($this->createNode('MsgId', 'D20180620-3532299663'), '//Document/CstmrDrctDbtInitn/GrpHdr');
      $this->appendNode($this->createNode('CreDtTm', '2018-06-20T09:01:51'), '//Document/CstmrDrctDbtInitn/GrpHdr');
      $this->appendNode($this->createNode('NbOfTxs', 4), '//Document/CstmrDrctDbtInitn/GrpHdr');
      $this->appendNode($this->createNode('CtrlSum', 97.99), '//Document/CstmrDrctDbtInitn/GrpHdr');
      $this->appendNode($this->createNode('InitgPty'));
      
      /*<MsgId>  D20180620-3532299663
      <CreDtTm> 2018-06-20T09:01:51
      <NbOfTxs>4</NbOfTxs>
      <CtrlSum>97.99</CtrlSum>
      <InitgPty>
      <Nm>Remote Office</Nm>
      </InitgPty*/
      
      
      echo $this->document->saveXML();
      
    }
  }

?>