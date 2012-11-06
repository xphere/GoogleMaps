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

use Google\Maps\Geocode\Response;

class JsonParser
{
    public function parse($request)
    {
        $json = is_string($request) ? json_decode($request) : $request;

        foreach ($json->results as $key => $result) {
            array_walk($result->address_components, function ($ac) {
                return new AddressComponent($ac->long_name, $ac->short_name, $ac->types);
            });
            $result->geometry = isset($result->geometry) ? $this->parseGeometry($result->geometry) : null;
            $json->results[$key] = new Result(
                $result->formatted_address,
                $result->address_components,
                $result->types,
                $result->geometry,
                isset($result->partial_match) ? $result->partial_match : false
            );
        };

        return new Response($json->results, $json->status);
    }

    private function parseLocation($location)
    {
        return new Location($location->lat, $location->lng);
    }

    private function parseViewport($viewport)
    {
        $southwest = $this->parseLocation($viewport->southwest);
        $northeast = $this->parseLocation($viewport->northeast);
        return new Viewport($southwest, $northeast);
    }

    private function parseGeometry($geometry)
    {
        $location = $this->parseLocation($geometry->location);
        $viewport = $this->parseViewport($geometry->viewport);
        $bounds = isset($geometry->bounds) ? $this->parseViewport($geometry->bounds) : null;
        return new Geometry($location, $geometry->location_type, $viewport, $bounds);
    }
}
