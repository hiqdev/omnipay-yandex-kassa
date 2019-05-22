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

use Omnipay\YandexKassa\Message\DetailsRequest;
use Omnipay\YandexKassa\Message\DetailsResponse;
use Omnipay\YandexKassa\Message\IncomingNotificationRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class DetailsResponseTest extends TestCase
{
    /** @var IncomingNotificationRequest */
    private $request;

    private $shopId                 = '54401';
    private $secretKey              = 'test_Fh8hUAVVBGUGbjmlzba6TB0iyUbos_lueTHE-axOwM0';
    private $transactionReference   = '2475e163-000f-5000-9000-18030530d620';

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest();
        $this->request = new DetailsRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize([
            'yandexClient'  => $this->buildYandexClient($this->shopId, $this->secretKey),
            'shopId'        => $this->shopId,
            'secret'        => $this->secretKey,
            'transactionReference' => $this->transactionReference,
        ]);
    }

    public function testSuccess(): void
    {
        $curlClientStub = $this->getCurlClientStub();
        $curlClientStub->method('sendRequest')
                       ->willReturn([
                           [],
                           $this->fixture('payment.waiting_for_capture'),
                           ['http_code' => 200],
                       ]);

        $this->getYandexClient($this->request)
             ->setApiClient($curlClientStub)
             ->setAuth($this->shopId, $this->secretKey);

        /** @var DetailsResponse $response */
        $response = $this->request->send();

        $this->assertInstanceOf(DetailsResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5ce3cdb0d1436', $response->getTransactionId());
        $this->assertSame('2475e163-000f-5000-9000-18030530d620', $response->getTransactionReference());
        $this->assertSame('187.50', $response->getAmount());
        $this->assertSame('RUB', $response->getCurrency());
        $this->assertSame('2019-05-21T10:09:54+00:00', $response->getPaymentDate()->format(\DATE_ATOM));
        $this->assertSame('waiting_for_capture', $response->getState());
        $this->assertSame('Bank card *4444', $response->getPayer());
    }
}
