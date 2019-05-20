<?php

namespace Omnipay\YandexKassa\Tests\Message;

use YandexCheckout\Client;

class TestCase extends \Omnipay\Tests\TestCase
{
    protected function buildYandexClient(string $shopId, string $secretKey): Client
    {
        $client = new Client();
        $client->setAuth($shopId, $secretKey);

        return $client;
    }
}
