<?php
/**
 * YandexKassa driver for the Omnipay PHP payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-YandexKassa
 * @package   omnipay-YandexKassa
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YandexKassa\Tests\Message;

use Omnipay\YandexKassa\Message\PurchaseRequest;
use YandexCheckout\Model\Confirmation\ConfirmationRedirect;
use YandexCheckout\Request\Payments\CreatePaymentResponse;

class PurchaseRequestTest extends TestCase
{
    /** @var \Omnipay\YandexKassa\Message\PurchaseRequest */
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

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertInstanceOf(CreatePaymentResponse::class, $data);

        $this->assertInstanceOf(ConfirmationRedirect::class, $data->getConfirmation());
        $this->assertSame($this->transactionId, $data->getMetadata()['transactionId']);
//        $this->assertSame($this->returnUrl,     $data); // Not possible to check the ReturnURL in CreatePaymentResponse
        $this->assertSame($this->amount,        $data->getAmount()->getValue());
        $this->assertSame($this->currency,      $data->getAmount()->getCurrency());
    }

    public function testSendData()
    {
        $data = $this->request->getData();
        $response = $this->request->sendData($data);

        $this->assertInstanceOf(\Omnipay\YandexKassa\Message\PurchaseResponse::class, $response);
    }
}
