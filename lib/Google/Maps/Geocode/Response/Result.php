<?php

/*
* This file is part of the Google\Maps\Geocode package
*
* (c) Berny Cantos <be@rny.cc>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Google\Maps\Geocode\Response;

class Result
{
    private $formatted_address;
    private $address_components = array();
    private $types = array();
    private $geometry;
    private $partial_match;

    public function __construct(
            $formatted_address,
            array $address_components = array(),
            array $types = array(),
            Geometry $geometry = null,
            $partial_match = false
    ) {
        $this->formatted_address = $formatted_address;
        $this->address_components = $address_components;
        $this->types = $types;
        $this->geometry = $geometry;
        $this->partial_match = (bool) $partial_match;
    }

    public function getFormattedAddress()
    {
        return $this->formatted_address;
    }

    public function getAddressComponents()
    {
        return $this->address_components;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function hasType($type)
    {
        return in_array($type, $this->types);
    }

    public function getGeometry()
    {
        return $this->geometry;
    }

    public function isPartialMatch()
    {
        return $this->partial_match;
    }
}
