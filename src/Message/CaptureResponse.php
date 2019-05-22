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

use Omnipay\Common\Exception\InvalidResponseException;
use YandexCheckout\Model\PaymentStatus;
use YandexCheckout\Request\Payments\Payment\CreateCaptureResponse;

/**
 * Class CaptureResponse.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @property CreateCaptureResponse $data
 */
class CaptureResponse extends DetailsResponse
{
    protected function ensureResponseIsValid(): void
    {
        parent::ensureResponseIsValid();

        if ($this->getState() !== PaymentStatus::SUCCEEDED) {
            throw new InvalidResponseException(sprintf('Failed to capture payment "%s"', $this->getTransactionReference()));
        }
    }
}
