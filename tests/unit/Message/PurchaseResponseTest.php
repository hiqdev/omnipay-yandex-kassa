<?php
/**
 * Ikajo driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-ikajo
 * @package   omnipay-ikajo
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YandexKassa\Tests\Message;

use Omnipay\YandexKassa\Message\PurchaseRequest;

class PurchaseResponseTest extends TestCase
{
    /** @var PurchaseRequest */
    private $request;

    private $shopId         = '54401';
    private $secretKey      = 'test_Fh8hUAVVBGUGbjmlzba6TB0iyUbos_lueTHE-axOwM0';

    private $transactionId  = 'sadf2345asf';
    private $amount         = '12.46';
    private $currency       = 'RUB';
    private $description    = 'Test completePurchase description';
    private $returnUrl      = 'https://www.foodstore.com/success';

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'yandexClient'  => $this->buildYandexClient($this->shopId, $this->secretKey),
            'transactionId' => $this->transactionId,
            'amount'        => $this->amount,
            'currency'      => $this->currency,
            'details'       => $this->description,
            'returnUrl'     => $this->returnUrl,
        ]);
    }

    public function testSuccess()
    {
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('GET', $response->getRedirectMethod());
        $this->assertStringStartsWith('https://money.yandex.ru/api-pages/v2/payment-confirm/epl?orderId=', $response->getRedirectUrl());
        $this->assertEmpty($response->getRedirectData());
    }
}
