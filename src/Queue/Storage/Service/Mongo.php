<?php

  namespace LibX\Queue\Storage\Service;

  use LibX\Queue\Storage\StorageInterface;
  use LibX\Queue\QueueableInterface;
  use LibX\Queue\Queue;

  //use LibX\Database\NoSQL\Mongo;

  class Mongo implements StorageInterface
  {
    protected $mongo;

    public function __construct($mongo)
    {
      $this->mongo = $mongo;
    }

    public function enqueue(Queue $queue, $queueable)
    {
      $identifier = $queue->identify();

      $collection = $this->mongo->queues->$identifier;

      $document = array();
      $document['created'] = new \MongoDB\BSON\UTCDateTime();
      $document['data'] = $queueable;

      $result = $collection->insertOne($document);

      if (!empty($result) && $result->isAcknowledged())
      {
        return $result->getInsertedId();
      }

      return false;
    }

    public function dequeue(Queue $queue)
    {
      $identifier = $queue->identify();

      $collection = $this->mongo->queues->$identifier;

      $cursor = $collection->find([], [
        'sort' => ['created' => -1],
        'limit' => 1
      ]);

      $documents = iterator_to_array($cursor);

      if(count($documents) > 0)
      {
        $document = array_pop($documents);

        // Remove from collection
        $collection->deleteOne(['_id' => $document->_id]);

        $data = $document->data;

        return json_decode($data);
      }

      return null;
    }
  }

?>