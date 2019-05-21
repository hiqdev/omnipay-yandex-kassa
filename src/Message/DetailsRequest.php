<?php

namespace Omnipay\YandexKassa\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class DetailsRequest
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class DetailsRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        return [];
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return DetailsResponse|ResponseInterface
     * @throws InvalidResponseException
     */
    public function sendData($data): ResponseInterface
    {
        try {
            $response = $this->client->getPaymentInfo($this->getTransactionReference());

            return new DetailsResponse($this, $response);
        } catch (\Throwable $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }
}
