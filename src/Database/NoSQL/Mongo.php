<?php

  namespace LibX\Database\NoSQL;

  class Mongo
  {
    protected $client;

    public function __construct()
    {
      $driverOptions = [
        'typeMap' => [
          'root' => 'array',
          'document' => 'array',
          'array' => 'array'
        ]
      ];

      // Load mongo client
      $this->client = new \MongoDB\Client('mongodb://localhost:27017', [], $driverOptions);
    }

    public function getClient()
    {
      return $this->client;
    }
  }

?>