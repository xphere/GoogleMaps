<?php

/*
* This file is part of the Berny\Google\Maps\Geocode package
*
* (c) Berny Cantos <be@rny.cc>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Berny\Google\Maps\Geocode\Response;

class Viewport
{
    private $southwest;
    private $northeast;

    public function __construct(Location $southwest, Location $northeast)
    {
        $this->southwest = $southwest;
        $this->northeast = $northeast;
    }

    public function getSouthwest()
    {
        return $this->southwest;
    }

    public function getNortheast()
    {
        return $this->northeast;
    }
}
