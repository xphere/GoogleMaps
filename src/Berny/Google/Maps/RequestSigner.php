<?php

/*
* This file is part of the Berny\Google\Maps\Geocode package
*
* (c) Berny Cantos <be@rny.cc>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Berny\Google\Maps;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RequestSigner implements EventSubscriberInterface
{
    private $key;
    private $clientId;

    public function __construct($clientId, $key)
    {
        $this->clientId = $clientId;
        $this->key = $this->decode($key);
    }

    public function attachTo($service)
    {
        $service->getClient()->addSubscriber($this);
        return $this;
    }

    public function onBeforeSend(Event $event)
    {
        $url = $event['request']->getUrl(true);
        $signature = $this->getSignature($url);
        $url->getQuery()
            ->add('signature', $signature)
            ->add('client', $this->clientId);
        $event['request']->setUrl($url);
    }

    private function getSignature($url)
    {
        $parsed_url = parse_url($url);
        $sensitive_url = $parsed_url['path'] . '?' . $parsed_url['query'];
        return $this->encode(hash_hmac('sha1', $sensitive_url, $this->key, true));
    }

    private function encode($value)
    {
        return strtr(base64_encode($value), '+/', '-_');
    }

    private function decode($value)
    {
        return base64_decode(strtr($value, '-_', '+/'));
    }

    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => 'onBeforeSend',
        );
    }
}
