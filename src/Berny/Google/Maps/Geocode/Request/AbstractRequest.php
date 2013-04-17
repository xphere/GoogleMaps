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

abstract class AbstractRequest
{
    private $sensor = false;
    private $bounds;
    private $language;
    private $region;
    private $components = array();

    public function addComponents(array $components)
    {
        foreach ($components as $type => $component) {
            $this->components[strtolower($type)] = (string) $component;
        }
        return $this;
    }

    public function setSensor($hasSensor)
    {
        $this->sensor = (bool) $hasSensor;
        return $this;
    }

    public function setBounds($fromLat, $fromLng, $toLat, $toLng)
    {
        $this->bounds = "{$fromLat},{$fromLng}|{$toLat},{$toLng}";
        return $this;
    }

    public function clearBounds()
    {
        $this->bounds = null;
        return $this;
    }

    public function setLanguage($language)
    {
        $this->language = (string) $language;
        return $this;
    }

    public function setRegion($region)
    {
        $this->region = (string) $region;
        return $this;
    }

    protected function getRequestInfo()
    {
        $result = array(
            'sensor'   => $this->sensor ? 'true' : 'false',
        );

        if (!empty($this->components)) {
            $components = array();
            foreach ($this->components as $key => $value) {
                $components[$key] = "{$key}:{$value}";
            }
            $result['components'] = implode('|', $components);
        }

        if ($this->bounds) {
            $result['bounds'] = $this->bounds;
        }

        if ($this->language) {
            $result['language'] = $this->language;
        }

        if ($this->region) {
            $result['region'] = $this->region;
        }

        return $result;
    }

    public function getRequest()
    {
        $request = $this->getRequestInfo();
        ksort($request);
        return $request;
    }
}
