<?php
/**
 * Yandex.Kassa driver for Omnipay payment processing library
 *
 * @link      https://github.com/hiqdev/omnipay-yandex-kassa
 * @package   omnipay-yandex-kassa
 * @license   MIT
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\YandexKassa;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\YandexKassa\Message\AuthenticateRequest;
use Omnipay\YandexKassa\Message\CompletePurchaseRequest;
use Omnipay\YandexKassa\Message\DetailsRequest;
use Omnipay\YandexKassa\Message\DetailsResponse;
use Omnipay\YandexKassa\Message\PurchaseRequest;
use YandexCheckout\Client;

/**
 * Class Gateway.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Yandex.Kassa';
    }

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

    /**
     * @param array $parameters
     * @return PurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, array_merge($parameters, [
            'yandexClient' => $this->buildYandexClient($parameters),
        ]));
    }

    /**
     * @param array $parameters
     * @return CompletePurchaseRequest|\Omnipay\Common\Message\AbstractRequest
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|DetailsResponse
     */
    public function details(array $parameters = [])
    {
        if (!isset($parameters['access_token'])) {
            $authentication = $this->authenticate($parameters)->send();
            $parameters['access_token'] = $authentication->getAccessToken();
        }

        return $this->createRequest(DetailsRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AuthenticateRequest|AbstractRequest
     */
    public function authenticate(array $parameters = [])
    {
        return $this->createRequest(AuthenticateRequest::class, $parameters);
    }

    private function buildYandexClient(array $parameters): Client
    {
        $client = new Client();
        $client->setAuth($this->getShopId(), $this->getSecret());

        return $client;
    }
}
