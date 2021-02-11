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

    public function getCapture()
    {
        return $this->getParameter('capture');
    }

    public function setCapture($value)
    {
        return $this->setParameter('capture', $value);
    }

    public function getReceipt()
    {
        return $this->getParameter('receipt');
    }

    public function setReceipt($value)
    {
        return $this->setParameter('receipt', $value);
    }

    public function setYandexClient(Client $client): void
    {
        $this->client = $client;
    }
}
