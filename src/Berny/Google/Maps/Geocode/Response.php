<?php

/*
* This file is part of the Berny\Google\Maps\Geocode package
*
* (c) Berny Cantos <be@rny.cc>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Berny\Google\Maps\Geocode;

class Response
{
    const STATUS_OK = 'OK';
    const STATUS_ZERO_RESULTS = 'ZERO_RESULTS';
    const STATUS_OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const STATUS_REQUEST_DENIED = 'REQUEST_DENIED';
    const STATUS_INVALID_REQUEST = 'INVALID_REQUEST';

    private $results = array();
    private $status;

    public function __construct(array $results, $status)
    {
        $this->results = $results;
        $this->status = $status;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isOk()
    {
        return $this->getStatus() === self::STATUS_OK;
    }
}
