<?php

  namespace LibX\External\Bag;

  /**
   * BAG Address
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Address extends \LibX\Util\Address
  {
    protected $id;
    protected $stateCode;
    protected $municipalityCode;
    protected $cityCode;
    protected $districtCode;
    protected $neighbourhoodCode;

    protected $publicSpaceId;
    protected $numberIndicationId;
    protected $addressableObjectId;

    public function __construct()
    {

    }

    public function getId()
    {
      return $this->id;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function hasId()
    {
      return !is_null($this->id);
    }

    public function getStateCode()
    {
      return $this->stateCode;
    }

    public function setStateCode($stateCode)
    {
      $this->stateCode = $stateCode;
    }

    public function hasStateCode()
    {
      return !is_null($this->stateCode);
    }

    public function getMunicipalityCode()
    {
      return $this->municipalityCode;
    }

    public function setMunicipalityCode($municipalityCode)
    {
      $this->municipalityCode = $municipalityCode;
    }

    public function hasMunicipalityCode()
    {
      return !is_null($this->municipalityCode);
    }

    public function getCityCode()
    {
      return $this->cityCode;
    }

    public function setCityCode($cityCode)
    {
      $this->cityCode = $cityCode;
    }

    public function hasCityCode()
    {
      return !is_null($this->cityCode);
    }

    public function getDistrictCode()
    {
      return $this->districtCode;
    }

    public function setDistrictCode($districtCode)
    {
      $this->districtCode = $districtCode;
    }

    public function hasDistrictCode()
    {
      return !is_null($this->districtCode);
    }

    public function getNeighbourhoodCode()
    {
      return $this->neighbourhoodCode;
    }

    public function setNeighbourhoodCode($neighbourhoodCode)
    {
      $this->neighbourhoodCode = $neighbourhoodCode;
    }

    public function hasNeighbourhoodCode()
    {
      return !is_null($this->neighbourhoodCode);
    }

    public function getPublicSpaceId()
    {
      return $this->publicSpaceId;
    }

    public function setPublicSpaceId($publicSpaceId)
    {
      $this->publicSpaceId = $publicSpaceId;
    }

    public function hasPublicSpaceId()
    {
      return !is_null($this->publicSpaceId);
    }

    public function getNumberIndicationId()
    {
      return $this->numberIndicationId;
    }

    public function setNumberIndicationId($numberIndicationId)
    {
      $this->numberIndicationId = $numberIndicationId;
    }

    public function hasNumberIndicationId()
    {
      return !is_null($this->numberIndicationId);
    }

    public function getAddressableObjectId()
    {
      return $this->addressableObjectId;
    }

    public function setAddressableObjectId($addressableObjectId)
    {
      $this->addressableObjectId = $addressableObjectId;
    }

    public function hasAddressableObjectId()
    {
      return !is_null($this->addressableObjectId);
    }
  }

?>