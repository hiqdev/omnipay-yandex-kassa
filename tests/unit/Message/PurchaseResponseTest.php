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

use Omnipay\YandexKassa\Message\PurchaseRequest;
use Omnipay\YandexKassa\Message\PurchaseResponse;

class PurchaseResponseTest extends TestCase
{
    /** @var PurchaseRequest */
    private $request;

    private $shopId         = '54401';
    private $secretKey      = 'test_Fh8hUAVVBGUGbjmlzba6TB0iyUbos_lueTHE-axOwM0';

    private $transactionId  = '5ce3cdb0d1437';
    private $amount         = '12.46';
    private $currency       = 'RUB';
    private $description    = 'Test completePurchase description';
    private $returnUrl      = 'https://www.foodstore.com/success';
    private $capture        = false;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'yandexClient'  => $this->buildYandexClient($this->shopId, $this->secretKey),
            'transactionId' => $this->transactionId,
            'amount'        => $this->amount,
            'currency'      => $this->currency,
            'description'   => $this->description,
            'returnUrl'     => $this->returnUrl,
            'capture'       => $this->capture,
        ]);
    }

    public function testSuccess()
    {
        $curlClientStub = $this->getCurlClientStub();
        $curlClientStub->method('sendRequest')->willReturn([
            [],
            $this->fixture('payment.pending'),
            ['http_code' => 200],
        ]);

        $this->getYandexClient($this->request)
             ->setApiClient($curlClientStub)
             ->setAuth($this->shopId, $this->secretKey);

        /** @var PurchaseResponse $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('GET', $response->getRedirectMethod());
        $this->assertSame("https://money.yandex.ru/api-pages/v2/payment-confirm/epl?orderId={$response->getTransactionReference()}", $response->getRedirectUrl());
        $this->assertSame($this->transactionId, $response->getTransactionId());
        $this->assertSame('247732b9-000f-5000-a000-13d9c7c381a8', $response->getTransactionReference());
        $this->assertEmpty($response->getRedirectData());
    }
}
