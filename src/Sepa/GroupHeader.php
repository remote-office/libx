<?php

  namespace LibX\Sepa;
  
  use LibX\Util\Stack;
    
  class GroupHeader
  {
    protected $messageId;
    protected $created;
    protected $transactions;
    protected $sum;
    protected $initiator;
    
    public function __construct($messageId, $created, $transactions, $sum, PartyIdentification $initiator)
    {
      $this->messageId = $messageId;
      $this->created = $created;
      $this->transactions = $transactions;
      $this->sum = $sum;
      $this->initiator = $initiator;
    }
    
    public function toXml()
    {
      /*<MsgId>D20180620-3532299663</MsgId>
      <CreDtTm>2018-06-20T09:01:51</CreDtTm>
      <NbOfTxs>4</NbOfTxs>
      <CtrlSum>97.99</CtrlSum>
      <InitgPty>
      <Nm>Remote Office</Nm>
      </InitgPty*/
    }
  }
  
  class PartyIdentification
  {
    protected $name;
    protected $postalAddress;
    protected $id;
    
    public function __construct()
    {
      
    }
    
    public function toXml()
    {
      /*'Nm'
      'PstlAdr'
      'Id'*/
    }
  }
  
  class PaymentInformation
  {
    protected $id;
    protected $method;
    
  }
  
  class PaymentInformationStack extends Stack
  {
    
  }
  
  class PaymentTypeInformation
  {
    
  }
  
  abstract class TransactionInformation
  {
    protected $id;
  }
  
  class TransactionInformationStack extends Stack
  {
    
  }
  
  class DirectDebitInformation extends TransactionInformation
  {
    
  }
  
  abstract class Transaction
  {
    
  }
  
  class DirectDebitTransaction extends Transaction
  {
    
  }
  
  
  
?>