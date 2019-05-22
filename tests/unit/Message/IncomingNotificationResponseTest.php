<?php

namespace Omnipay\YandexKassa\Tests\Message;

use Omnipay\YandexKassa\Message\IncomingNotificationRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class IncomingNotificationResponseTest extends TestCase
{
    /** @var IncomingNotificationRequest */
    private $request;

    private $shopId         = '54401';
    private $secretKey      = 'test_Fh8hUAVVBGUGbjmlzba6TB0iyUbos_lueTHE-axOwM0';

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest([], [], [], [], [], [], $this->fixture('notification.payment.waiting_for_capture'));

        $this->request = new IncomingNotificationRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize([
            'shopId' => $this->shopId,
            'secret' => $this->secretKey,
        ]);
    }

    public function testSuccess()
    {
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame('5ce3cdb0d1436', $response->getTransactionId());
        $this->assertSame('2475e163-000f-5000-9000-18030530d620', $response->getTransactionReference());
    }
}
