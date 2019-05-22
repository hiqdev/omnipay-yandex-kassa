<?php
/**
 * Yandex.Kassa driver for Omnipay payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-yandex-kassa
 * @package   omnipay-yandex-kassa
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YandexKassa\Tests\Message;

use Omnipay\YandexKassa\Message\AbstractRequest;
use YandexCheckout\Client;

class TestCase extends \Omnipay\Tests\TestCase
{
    protected function buildYandexClient(string $shopId, string $secretKey): Client
    {
        $client = new Client();
        $client->setAuth($shopId, $secretKey);

        return $client;
    }

    protected function getCurlClientStub()
    {
        $clientStub = $this->getMockBuilder(Client\CurlClient::class)
                           ->setMethods(['sendRequest'])
                           ->getMock();

        return $clientStub;
    }

    protected function getYandexClient(AbstractRequest $request): Client
    {
        $clientReflection = (new \ReflectionObject($request))->getProperty('client');
        $clientReflection->setAccessible(true);

        return $clientReflection->getValue($request);
    }

    protected function fixture(string $name): string
    {
        return file_get_contents(__DIR__ . '/fixture/' . $name . '.json');
    }
}
