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
use Google\Maps\Geocode\Response\JsonParser;

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
        return (string) $this->getClient()
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
        $parser = new JsonParser();
        return $parser->parse($this->json($request));
    }
}
