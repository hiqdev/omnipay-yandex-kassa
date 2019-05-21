<?php
/**
 * Yandex.Kassa driver for Omnipay payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-yandex-kassa
 * @package   omnipay-yandex-kassa
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YandexKassa\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class IncomingNotificationResponse extends AbstractResponse
{
    /**
     * @return RequestInterface|AbstractRequest
     */
    public function getRequest()
    {
        return parent::getRequest();
    }

    /**
     * CompletePurchaseResponse constructor.
     * @param RequestInterface $request
     * @param array $data
     * @throws \Exception
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
    }

    public function getOrderId()
    {
        return $this->data['object']['metadata']['transactionId'] ?? null;
    }

    public function getTransactionReference()
    {
        return $this->data['object']['id'] ?? null;
    }

    public function isSuccessful()
    {
        return $this->getTransactionReference() !== null;
    }
}
