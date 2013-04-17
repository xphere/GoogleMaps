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

class Geometry
{
    const LOCATION_TYPE_ROOFTOP = 'ROOFTOP';
    const LOCATION_TYPE_RANGE_INTERPOLATED = 'RANGE_INTERPOLATED';
    const LOCATION_TYPE_GEOMETRIC_CENTER = 'GEOMETRIC_CENTER';
    const LOCATION_TYPE_APPROXIMATE = 'APPROXIMATE';

    private $location;
    private $location_type;
    private $viewport;
    private $bounds;

    public function __construct(Location $location, $location_type, Viewport $viewport, Viewport $bounds = null)
    {
        $this->location = $location;
        $this->location_type = $location_type;
        $this->viewport = $viewport;
        $this->bounds = $bounds;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getLocationType()
    {
        return $this->location_type;
    }

    public function isPrecise()
    {
        return $this->location_type === self::LOCATION_TYPE_ROOFTOP;
    }

    public function getViewport()
    {
        return $this->viewport;
    }

    public function getBounds()
    {
        return $this->bounds;
    }
}
