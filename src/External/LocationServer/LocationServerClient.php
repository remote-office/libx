<?php

  namespace LibX\External\LocationServer;

  use Exception;

  /**
   * Location Server Client
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class LocationServerClient extends \LibX\Json\Api\JsonApiClient
  {
    // Location server API url
    const API_URL = 'https://geodata.nationaalgeoregister.nl/locatieserver/v3';

    /**
     * Suggest an address id
     *
     * @param string $zipcode
     * @param integer $number
     * @param string $addition
     * @return string
     */
    public function suggest($zipcode, $number, $addition = null)
    {
      // Concat url
      $url = self::API_URL . '/suggest?q=' . $zipcode . '+' . $number . (!empty($addition) ? '+' . $addition : '');

      // Create a REST request
      $request = new \LibX\Net\Rest\Request($url, \LibX\Net\Rest\Request::REQUEST_METHOD_GET);

      // Create a REST response
      $response = new \LibX\Net\Rest\Response();

      // Make the call
      $data = $this->call($request, $response);

      if($data->response->numFound == 0)
        throw new Exception('No document found');

      if($data->response->numFound > 1)
      {
        $document = null;
        $score = 0;

        foreach($data->response->docs as $doc)
        {
          if($doc->score > $score && $doc->type === 'adres')
          {
            // Update score
            $score = $doc->score;

            $document = $doc;
          }
        }
      }
      else
      {
        // Get document
        $document = array_pop($data->response->docs);
      }

      //if($data->response->numFound > 1)
        //throw new Exception('More then one document found');

      // Check type
      if($document->type !== 'adres')
        throw new Exception('Invalid document type found (' . $document->type . ')');

      // Get address id
      $id = $document->id;

      return $id;

    }

    /**
     * Lookup an address id
     *
     * @param string $id
     * @return string
     */
    public function lookup($id)
    {
      // Concat url
      $url = self::API_URL . '/lookup?id=' . $id;

      // Create a REST request
      $request = new \LibX\Net\Rest\Request($url, \LibX\Net\Rest\Request::REQUEST_METHOD_GET);

      // Create a REST response
      $response = new \LibX\Net\Rest\Response();

      // Make the call
      $data = $this->call($request, $response);

      if($data->response->numFound == 0)
        throw new Exception('No document found');

      if($data->response->numFound > 1)
        throw new Exception('More then one document found');

      // Get document
      $document = array_pop($data->response->docs);

      // Check type
      if($document->type !== 'adres')
        throw new Exception('Invalid document type found (' . $doc->type . ')');

      $state = $document->provincienaam;
      $municipality = $document->gemeentenaam;
      $city = $document->woonplaatsnaam;
      $area = $document->wijknaam;
      $neighbourhood = $document->buurtnaam;
      $street = $document->straatnaam;
      $number = $document->huisnummer;

      if(isset($document->huisnummertoevoeging) && isset($document->huisletter))
        $addition = $document->huisnummertoevoeging . $document->huisletter;
      elseif(isset($document->huisnummertoevoeging))
        $addition = $document->huisnummertoevoeging;
      elseif(isset($document->huisletter))
        $addition = $document->huisletter;
      else
        $addition = null;

      $zipcode = $document->postcode;

      if($document->bron === 'BAG')
      {
        $address = new \LibX\External\Bag\Address();
        $address->setId($document->id);
        $address->setStateCode($document->provinciecode);
        $address->setMunicipalityCode($document->gemeentecode);
        $address->setCityCode($document->woonplaatscode);
        $address->setDistrictCode($document->wijkcode);
        $address->setNeighbourhoodCode($document->buurtcode);
        $address->setPublicSpaceId($document->openbareruimte_id);
        $address->setNumberIndicationId($document->nummeraanduiding_id);
        $address->setAddressableObjectId($document->adresseerbaarobject_id);
      }
      else
      {
        $address = new \LibX\Util\Address();
      }

      $address->setCountry('Nederland');
      $address->setState($state);
      $address->setMunicipality($municipality);
      $address->setCity($city);
      $address->setDistrict($area);
      $address->setNeighbourhood($neighbourhood);
      $address->setStreet($street);
      $address->setNumber($number);
      $address->setAddition($addition);
      $address->setZipcode($zipcode);

      return $address;
    }
  }

?>