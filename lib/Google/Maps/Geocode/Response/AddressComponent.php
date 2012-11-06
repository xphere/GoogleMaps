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

class AddressComponent
{
    const TYPE_STREET_ADDRESS = 'street_address';
    const TYPE_ROUTE = 'route';
    const TYPE_INTERSECTION = 'intersection';
    const TYPE_POLITICAL = 'political';
    const TYPE_COUNTRY = 'country';
    const TYPE_ADMINISTRATIVE_AREA_LEVEL_1 = 'administrative_area_level_1';
    const TYPE_ADMINISTRATIVE_AREA_LEVEL_2 = 'administrative_area_level_2';
    const TYPE_ADMINISTRATIVE_AREA_LEVEL_3 = 'administrative_area_level_3';
    const TYPE_COLLOQUIAL_AREA = 'colloquial_area';
    const TYPE_LOCALITY = 'locality';
    const TYPE_SUBLOCALITY = 'sublocality';
    const TYPE_NEIGHBORHOOD = 'neighborhood';
    const TYPE_PREMISE = 'premise';
    const TYPE_SUBPREMISE = 'subpremise';
    const TYPE_POSTAL_CODE = 'postal_code';
    const TYPE_NATURAL_FEATURE = 'natural_feature';
    const TYPE_AIRPORT = 'airport';
    const TYPE_PARK = 'park';
    const TYPE_POINT_OF_INTEREST = 'point_of_interest';
    const TYPE_POST_BOX = 'post_box';
    const TYPE_STREET_NUMBER = 'street_number';
    const TYPE_FLOOR = 'floor';
    const TYPE_ROOM = 'room';

    private $long_name;
    private $short_name;
    private $types = array();

    public function __construct($long_name, $short_name, array $types = null)
    {
        $this->long_name = $long_name;
        $this->short_name = $short_name;
        $this->types = $types;
    }

    public function getLongName()
    {
        return $this->long_name;
    }

    public function getShortName()
    {
        return $this->short_name;
    }

    public function getTypes()
    {
        return $this->types;
    }

    public function hasType($type)
    {
        return in_array($type, $this->types);
    }
}
