<?php

  namespace LibX\Util;

  use StdClass;
  
  /**
   * Class Address
   *
   * @author David Betgen <d.betgen@remote-office.nl>
   * @version 1.0
   */
  class Address
  {
    protected $country;
    protected $state;
    protected $municipality;
    protected $city;
    protected $district;
    protected $neighbourhood;
    protected $street;
    protected $number;
    protected $addition;
    protected $zipcode;

    protected $coordinates;

    /**
     * Construct an Address
     *
     * @param void
     * @return Address
     */
    public function __construct()
    {

    }

    public function getCountry()
    {
      return $this->country;
    }

    public function setCountry($country)
    {
      $this->country = $country;
    }

    public function hasCountry()
    {
      return !is_null($this->country);
    }

    public function getState()
    {
      return $this->state;
    }

    public function setState($state)
    {
      $this->state = $state;
    }

    public function hasState()
    {
      return !is_null($this->state);
    }

    public function getMunicipality()
    {
      return $this->municipality;
    }

    public function setMunicipality($municipality)
    {
      $this->municipality = $municipality;
    }

    public function hasMunicipality()
    {
      return !is_null($this->municipality);
    }

    public function getCity()
    {
      return $this->city;
    }

    public function setCity($city)
    {
      $this->city = $city;
    }

    public function hasCity()
    {
      return !is_null($this->city);
    }

    public function getDistrict()
    {
      return $this->district;
    }

    public function setDistrict($district)
    {
      $this->district = $district;
    }

    public function hasDistrict()
    {
      return !is_null($this->district);
    }

    public function getNeighbourhood()
    {
      return $this->neighbourhood;
    }

    public function setNeighbourhood($neighbourhood)
    {
      $this->neighbourhood = $neighbourhood;
    }

    public function hasNeighbourhood()
    {
      return !is_null($this->neighbourhood);
    }

    public function getStreet()
    {
      return $this->street;
    }

    public function setStreet($street)
    {
      $this->street = $street;
    }

    public function hasStreet()
    {
      return !is_null($this->street);
    }

    public function getNumber()
    {
      return $this->number;
    }

    public function setNumber($number)
    {
      $this->number = $number;
    }

    public function hasNumber()
    {
      return !is_null($this->number);
    }

    public function getAddition()
    {
      return $this->addition;
    }

    public function setAddition($addition)
    {
      $this->addition = $addition;
    }

    public function hasAddition()
    {
      return !is_null($this->addition);
    }

    public function getZipcode()
    {
      return $this->zipcode;
    }

    public function setZipcode($zipcode)
    {
      $this->zipcode = $zipcode;
    }

    public function hasZipcode()
    {
      return !is_null($this->zipcode);
    }

    public function getCoordinates()
    {
      return $this->coordinates;
    }

    public function setCoordinates(Coordinates $coordinates)
    {
      $this->coordinates = $coordinates;
    }

    public function hasCoordinates()
    {
      return !is_null($this->coordinates);
    }

    /**
     * Convert address to array
     *
     * @param void
     * @return NULL[]
     */
    public function toArray()
    {
      $_address = [];

      if($this->hasCountry())
        $_address['country'] = $this->getCountry();

      if($this->hasState())
        $_address['state'] = $this->getState();

      if($this->hasMunicipality())
        $_address['municipality'] = $this->getMunicipality();

      if($this->hasCity())
        $_address['city'] = $this->getCity();

      if($this->hasDistrict())
        $_address['district'] = $this->getDistrict();

      if($this->hasNeighbourhood())
        $_address['neighbourhood'] = $this->getNeighbourhood();

      if($this->hasStreet())
        $_address['street'] = $this->getStreet();

      if($this->hasNumber())
        $_address['number'] = $this->getNumber();

      if($this->hasAddition())
        $_address['addition'] = $this->getAddition();

      if($this->hasZipcode())
        $_address['zipcode'] = $this->getZipcode();

      return $_address;
    }

    /**
     * Convert from StdClass
     *
     * @param StdClass $_address
     * @return \LibX\Util\Address
     */
    public static function fromStdClass($_address)
    {
      $address = new static();

      if(isset($_address->country))
        $address->setCountry($_address->country);

      if(isset($_address->state))
        $address->setState($_address->state);

      if(isset($_address->municipality))
        $address->setMunicipality($_address->municipality);

      if(isset($_address->city))
        $address->setCity($_address->city);

      if(isset($_address->district))
        $address->setDistrict($_address->district);

      if(isset($_address->neighbourhood))
        $address->setNeighbourhood($_address->neighbourhood);

      if(isset($_address->street))
        $address->setStreet($_address->street);

      if(isset($_address->number))
        $address->setNumber($_address->number);

      if(isset($_address->addition))
        $address->setAddition($_address->addition);

      if(isset($_address->zipcode))
        $address->setZipcode($_address->zipcode);

      return $address;
    }
  }

?>