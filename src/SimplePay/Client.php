<?php

  namespace LibX\SimplePay;
  
  use LibX\SimplePay\Provider;
  use LibX\SimplePay\Transaction;
  use LibX\SimplePay\Status;
  
  use LibX\SimplePay\User;
  use LibX\SimplePay\Payment;
  use LibX\SimplePay\Callback;
  use LibX\SimplePay\Authenticator;
  
  use LibX\SimplePay\Request\ProviderRequest;
  use LibX\SimplePay\Request\TransactionRequest;
  use LibX\SimplePay\Request\StatusRequest;
  
  use LibX\SimplePay\Response\ProviderResponse;
  use LibX\SimplePay\Response\TransactionResponse;
  use LibX\SimplePay\Response\StatusResponse;
  
  use LibX\SimplePay\Account\IdealAccount;
  use LibX\SimplePay\Account\IncassoAccount;
  use LibX\SimplePay\Account\CreditCardAccount;
  use LibX\SimplePay\Account\PrepaidAccount;
  
  use LibX\Util\Uuid;
  
  use StdClass;
  
                  
  /**
   * Client
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Client extends \LibX\Webservice\Client
  {
    /**
     * Provider request
     *
     * @param ProviderRequest $providerRequest
     * @return ProviderResponse
     */
    public function provider(ProviderRequest $providerRequest)
    {
      // Extract SimplePay user from request
      $user = $providerRequest->getUser();
      
      // Create request
      $request = new StdClass();
      $request->User = new StdClass();
      $request->User->Uuid = $user->getUuid()->getValue();
      $request->User->Hash = $user->getHash();
      
      /*$request = new StdClass();
       $request->Auth = new StdClass();
       $request->Auth->Uuid
       $request->Auth->Method
       $request->Auth->Signature
       $request->Auth->Token
       $request->Auth->Timestamp
       $request->Auth->Nonce
       $request->Auth->Version*/
      
      // Check type
      if($providerRequest->hasType())
        $request->Type = $providerRequest->getType();
        
      // Send request
      $response = $this->getSoapClient()->provider($request);
  
      // Create a new ProviderResponse
      $providerResponse = new ProviderResponse();
      
      if(!is_array($response->Provider))
        $response->Provider = array($response->Provider);
        
      foreach($response->Provider as $provider)
      {
        // Extract values from reponse
        $uuid = $provider->Uuid;
        $name = $provider->Name;
        $type = $provider->Type;
        
        $uuid = new Uuid($uuid);
        
        // Create a new Provider
        $provider = new Provider($uuid, $name, $type);
        
        // Add bank to response
        $providerResponse->addProvider($provider);
      }
      
      return $providerResponse;
    }
    
    /**
     * Transaction request
     *
     * @param TransactionRequest $transactionRequest
     * @return TransactionResponse
     */
    public function transaction(TransactionRequest $transactionRequest)
    {
      // Extract SimplePay user from request
      $user = $transactionRequest->getUser();
      $provider = $transactionRequest->getProvider();
      $payment = $transactionRequest->getPayment();
      
      // Create request
      $request = new StdClass();
      $request->User = new StdClass();
      $request->User->Uuid = $user->getUuid()->getValue();
      $request->User->Hash = $user->getHash();
      
      // Provider
      $request->Provider = new StdClass();
      $request->Provider->Uuid = $provider->getValue();
      
      // Payment
      $request->Payment = new StdClass();
      $request->Payment->Reference = $payment->getReference();
      $request->Payment->Amount = $payment->getAmount();
      $request->Payment->Currency = $payment->getCurrency();
      
      if($payment->hasDescription())
        $request->Payment->Description = $payment->getDescription();
        
      // Account
      if($payment->hasAccount())
      {
        $account = $payment->getAccount();
        
        if($account instanceof IdealAccount)
        {
          $request->Payment->Account = new StdClass();
          $request->Payment->Account->Ideal = new StdClass();
        }
        elseif($account instanceof IncassoAccount)
        {
          $request->Payment->Account = new StdClass();
          $request->Payment->Account->Incasso = new StdClass();
          $request->Payment->Account->Incasso->Holder = $account->getHolder();
          $request->Payment->Account->Incasso->Number = $account->getNumber();
          $request->Payment->Account->Incasso->City = $account->getCity();
        }
        elseif($account instanceof CreditCardAccount)
        {
          // Not implemented yet
          $request->Payment->Account = new StdClass();
          $request->Payment->Account->CreditCard = new StdClass();
        }
        elseif($account instanceof PrepaidAccount)
        {
          // Not implemented yet
          $request->Payment->Account = new StdClass();
          $request->Payment->Account->Prepaid = new StdClass();
        }
      }
      
      // Callback
      $callback = $transactionRequest->getCallback();
      
      // Old request
      $request->Options = new StdClass();
      $request->Options->Ideal = new StdClass();
      $request->Options->Ideal->SiteUrl = $callback->getRedirectUrl();
      $request->Options->Ideal->CallbackUrl = $callback->getCallbackUrl();
      
      // Send request
      $response = $this->getSoapClient()->transaction($request);
      
      // Transaction
      $transaction = new Uuid($response->Transaction->Uuid);
      
      // Authenticator
      $uuid = new Uuid($response->Authenticator->Uuid);
      $name = $response->Authenticator->Name;
      $authenticationUrl = $response->Authenticator->AuthenticationUrl;
      
      $authenticator = new Authenticator($uuid, $name, $authenticationUrl);
      
      $transactionResponse = new TransactionResponse($transaction, $authenticator);
      
      return $transactionResponse;
    }
    
    /**
     * Status request
     *
     * @param StatusRequest $statusRequest
     * @return StatusResponse
     */
    public function status(StatusRequest $statusRequest)
    {
      // Extract SimplePay user from request
      $user = $statusRequest->getUser();
      $transaction = $statusRequest->getTransaction();
      
      // Create request
      $request = new StdClass();
      $request->User = new StdClass();
      $request->User->Uuid = $user->getUuid()->getValue();
      $request->User->Hash = $user->getHash();
      
      $request->Transaction = new StdClass();
      $request->Transaction->Uuid = $transaction->getValue();
      
      // Send request
      $response = $this->getSoapClient()->status($request);
      
      $uuid = new Uuid($response->Transaction->Uuid);
      $status = $response->Transaction->Status;
      
      // Create Transaction
      $transaction = new Transaction($uuid, $status);
      
      $reference = $response->Payment->Reference;
      $amount = $response->Payment->Amount;
      $currency = $response->Payment->Currency;
      
      // Create Payment
      $payment = new Payment($reference, $amount, $currency);
      
      if(isset($response->Payment->Description))
        $payment->setDescription($response->Payment->Description);
        
      $statusResponse = new StatusResponse($transaction, $payment);
        
      return $statusResponse;
    }
  }
  
?>