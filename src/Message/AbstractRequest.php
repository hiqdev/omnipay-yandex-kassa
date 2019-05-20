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

use YandexCheckout\Client;

/**
 * Class AbstractRequest.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * @var Client
     */
    protected $client;

    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function setYandexClient(Client $client): void
    {
        $this->client = $client;
    }

//    public function getTransactionId()
//    {
//        return $this->getParameter('orderId');
//    }
//
//    public function setTransactionId($value)
//    {
//        return $this->setParameter('orderId', $value);
//    }
//
//    public function getOrderId()
//    {
//        return $this->getParameter('orderId');
//    }
//
//    public function setOrderId($value)
//    {
//        return $this->setParameter('orderId', $value);
//    }
}
