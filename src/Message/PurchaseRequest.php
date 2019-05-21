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

use Omnipay\Common\Exception\InvalidRequestException;
use Throwable;
use YandexCheckout\Request\Payments\CreatePaymentResponse;

/**
 * Class PurchaseRequest.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @return CreatePaymentResponse
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'returnUrl', 'transactionId');

        try {
            $paymentResponse = $this->client->createPayment([
                'amount' => [
                    'value' => $this->getAmount(),
                    'currency' => $this->getCurrency(),
                ],
                'description' => $this->getDetails(),
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => $this->getReturnUrl(),
                ],
                'metadata' => [
                    'transactionId' => $this->getTransactionId(),
                ],
            ], 'create-' . $this->getTransactionId());

            return $paymentResponse;
        } catch (Throwable $e) {
            throw new InvalidRequestException('Failed to request purchase: ' . $e->getMessage(), 0, $e);
        }
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function getDetails(): ?string
    {
        return $this->getParameter('details');
    }

    public function setDetails(string $value)
    {
        return $this->setParameter('details', $value);
    }
}

