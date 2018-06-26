<?php

namespace RenfeBot\Infrastructure\Goutte;

use Goutte\Client;

final class ClientFactory
{
    private const TIMEOUT = 60;

    public function build(): Client
    {
        $client       = new Client();
        $guzzleClient = new \GuzzleHttp\Client(['timeout' => self::TIMEOUT]);
        $client->setClient($guzzleClient);

        return $client;
    }
}
