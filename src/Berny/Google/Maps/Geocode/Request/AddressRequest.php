<?php

/*
* This file is part of the Berny\Google\Maps\Geocode package
*
* (c) Berny Cantos <be@rny.cc>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Berny\Google\Maps\Geocode\Request;

class AddressRequest extends AbstractRequest
{
    private $address;

    public function __construct($address)
    {
        $this->address = $address;
    }

    protected function getRequestInfo()
    {
        $result = parent::getRequestInfo();
        $result['address'] = $this->address;
        return $result;
    }
}
