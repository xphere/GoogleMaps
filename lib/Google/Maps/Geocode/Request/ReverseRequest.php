<?php

/*
* This file is part of the Google\Maps\Geocode package
*
* (c) Berny Cantos <be@rny.cc>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Google\Maps\Geocode\Request;

class ReverseRequest extends AbstractRequest
{
    private $latitude;
    private $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    protected function getRequestInfo()
    {
        $result = parent::getRequestInfo();
        $result['latlng'] = "{$this->latitude},{$this->longitude}";
        return $result;
    }
}
