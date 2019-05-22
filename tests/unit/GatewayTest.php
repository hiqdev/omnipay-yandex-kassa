<?php
/**
 * Ikajo driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-ikajo
 * @package   omnipay-ikajo
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YandexKassa\Tests;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\YandexKassa\Gateway;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    public $gateway;

    private $shopId         = '54401';
    private $secretKey      = 'test_Fh8hUAVVBGUGbjmlzba6TB0iyUbos_lueTHE-axOwM0';

    private $transactionId  = 'sadf2345asf';
    private $amount         = '12.46';
    private $currency       = 'USD';
    private $description    = 'Test completePurchase description';

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setShopId($this->shopId);
        $this->gateway->setSecret($this->secretKey);
    }

    public function testGateway()
    {
        $this->assertSame($this->shopId,     $this->gateway->getShopId());
        $this->assertSame($this->secretKey,  $this->gateway->getSecret());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'transactionId' => $this->transactionId,
            'amount'        => $this->amount,
            'currency'      => $this->currency,
            'description'   => $this->description,
        ]);

        $this->assertSame($this->transactionId, $request->getTransactionId());
        $this->assertSame($this->description,   $request->getDescription());
        $this->assertSame($this->currency,      $request->getCurrency());
        $this->assertSame($this->amount,        $request->getAmount());
    }
}
