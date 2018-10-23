<?php

  namespace LibX\External\Bag\Api;

  use Exception;
use LibX\Util\Coordinates;
use LibX\Util\PointStack;
use LibX\Util\Polygon;

  /**
   * BAG Client
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class BagClient extends \LibX\Json\Api\JsonApiClient
  {
    // BAG API key
    const API_KEY = 'f5f21a97-07f9-481a-b878-92c1e29dbbb2';

    // BAG API url
    const API_URL = 'https://bag.basisregistraties.overheid.nl/api/v1';

    // BAG API Types
    const TYPE_PAND             = 'panden';
    const TYPE_LIGPLAATS        = 'ligplaatsen';
    const TYPE_STANDPLAATS      = 'standplaatsen';
    const TYPE_VERBLIJFSOBJECT  = 'verblijfsobjecten';
    const TYPE_OPENBARE_RUIMTE  = 'openbare-ruimtes';
    const TYPE_NUMMERAANDUIDING = 'nummeraanduidingen';
    const TYPE_WOONPLAATS       = 'woonplaatsen';

    /**
     * Retrieve number indications
     *
     * @param string $zipcode
     * @param integer $number
     * @return NULL
     */
    public function numberindication($zipcode, $number)
    {
      // Concat url
      $url = self::API_URL . '/nummeraanduidingen';

      // Create a REST request
      $request = new \LibX\Net\Rest\Request($url, \LibX\Net\Rest\Request::REQUEST_METHOD_GET);

      $parameters = [];
      $parameters['postcode'] = $zipcode;
      $parameters['huisnummer'] = $number;

      $request->setParameters($parameters);

      // Create a REST response
      $response = new \LibX\Net\Rest\Response();

      // Make the call
      $data = $this->call($request, $response);

      $indications = $data->_embedded->nummeraanduidingen;

      foreach($indications as $indication)
      {

      }
    }

    /**
     * Search BAG data
     *
     * @param string $type
     * @param Polygon $polygon
     * @return NULL
     */
    public function search($type, Polygon $polygon)
    {
      // Concat url
      $url = self::API_URL . '/' . $type;

      $data = new \StdClass();
      $data->geometrie = new \StdClass();
      $data->geometrie->contains = new \StdClass();
      $data->geometrie->contains->type = 'Point'; // Polygon??
      $data->geometrie->contains->coordinates = [];

      $points = $polygon->getPoints();

      foreach($points as $point)
        $data->geometrie->contains->coordinates[] = [$point->getX(), $point->getY()];

      // Create a REST request
      $request = new \LibX\Net\Rest\Request($url, \LibX\Net\Rest\Request::REQUEST_METHOD_POST);
      $request->setData(json_encode($data));

      // Create a REST response
      $response = new \LibX\Net\Rest\Response();

      // Not working at the moment
      return;

      // Make the call
      $data = $this->call($request, $response);
    }

    /**
     * Retrieve BAG details
     *
     * @param string $type
     * @param string $id
     */
    public function details($type, $id)
    {
      // Concat url
      $url = self::API_URL . '/' . $type . '/' . $id;

      // Create a REST request
      $request = new \LibX\Net\Rest\Request($url, \LibX\Net\Rest\Request::REQUEST_METHOD_GET);

      // Create a REST response
      $response = new \LibX\Net\Rest\Response();

      // Make the call
      $data = $this->call($request, $response);

      //return $data->_embedded;
      return $data;
    }

    /**
     * Retrieve BAG geo data
     *
     * @param string $type
     * @param string $id
     * @return NULL|\LibX\Util\Coordinates
     */
    public function geo($type, $id)
    {
      // Concat url
      $url = self::API_URL . '/' . $type . '/' . $id;

      // Create a REST request
      $request = new \LibX\Net\Rest\Request($url, \LibX\Net\Rest\Request::REQUEST_METHOD_GET);

      // Create a REST response
      $response = new \LibX\Net\Rest\Response();

      // Make the call
      $data = $this->call($request, $response);

      // Init
      $coordinates = null;

      // Get geo data
      if(isset($data->_embedded->geometrie))
      {
        $geo = $data->_embedded->geometrie;

        if($geo->type === 'Point')
        {
          $longitude = $geo->coordinates[0];
          $latitude = $geo->coordinates[1];

          $coordinates = new Coordinates($latitude, $longitude);
        }
        elseif($geo->type === 'Polygon')
        {
          $points = new PointStack();

          foreach($geo->coordinates[0] as $coordinates)
          {
            $longitude = $coordinates[0];
            $latitude = $coordinates[1];

            $points->push(new Coordinates($latitude, $longitude));
          }

          $coordinates = new Polygon($points);
        }
      }

      return $coordinates;
    }

    /**
     * @inheritdoc
     */
    protected function call(\LibX\Net\Rest\Request $request, \LibX\Net\Rest\Response $response)
    {
      // Add API key header
      $request->setHeader('X-Api-Key: ' . self::API_KEY);

      return parent::call($request, $response);
    }

    /**
     * Test call
     */
    private function test()
    {
      // Concat url
      $url = self::API_URL . '/' . self::TYPE_WOONPLAATS;

      // Create a REST request
      $request = new \LibX\Net\Rest\Request($url, \LibX\Net\Rest\Request::REQUEST_METHOD_GET);

      // Create a REST response
      $response = new \LibX\Net\Rest\Response();

      // Make the call
      $data = $this->call($request, $response);

      print_r($data);
    }
  }

?>