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

use Omnipay\YandexKassa\Message\IncomingNotificationRequest;
use Omnipay\YandexKassa\Message\IncomingNotificationResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class IncomingNotificationRequestTest extends TestCase
{
    /** @var IncomingNotificationRequest */
    private $request;

    private $shopId                 = '54401';
    private $secretKey              = 'test_Fh8hUAVVBGUGbjmlzba6TB0iyUbos_lueTHE-axOwM0';

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

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame(json_decode($this->fixture('notification.payment.waiting_for_capture'), true), $data);
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);

        $this->assertInstanceOf(IncomingNotificationResponse::class, $response);
    }
}
