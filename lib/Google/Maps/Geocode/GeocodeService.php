<?php

/*
* This file is part of the Google\Maps\Geocode package
*
* (c) Berny Cantos <be@rny.cc>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Google\Maps\Geocode;

use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Google\Maps\Geocode\Request\AbstractRequest;
use Google\Maps\Geocode\Response\AddressComponent;
use Google\Maps\Geocode\Response\Geometry;
use Google\Maps\Geocode\Response\Location;
use Google\Maps\Geocode\Response\Result;
use Google\Maps\Geocode\Response\Viewport;

class GeocodeService
{
    const URL = 'http://maps.googleapis.com/maps/api/geocode/{method}{?request*}';

    private $client;

    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        if (empty($this->client)) {
            $this->client = new Client;
        }
        return $this->client;
    }

    public function json(AbstractRequest $request)
    {
        return $this->call('json', $request);
    }

    public function xml(AbstractRequest $request)
    {
        return $this->call('xml', $request);
    }

    private function call($method, AbstractRequest $request)
    {
        return $this->getClient()
            ->get(array(
                static::URL,
                array(
                    'method' => $method,
                    'request' => $request->getRequest(),
                )
            ))
            ->send()
            ->getBody()
        ;
    }

    public function query(AbstractRequest $request)
    {
        $json = json_decode($this->json($request));

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
