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
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use YandexCheckout\Model\Confirmation\ConfirmationRedirect;
use YandexCheckout\Request\Payments\CreatePaymentResponse;

/**
 * Class PurchaseResponse.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 *
 *
 * @property CreatePaymentResponse $data
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function getRedirectUrl()
    {
        $confirmation = $this->data->getConfirmation();
        if (!$confirmation instanceof ConfirmationRedirect) {
            throw new InvalidResponseException('Only redirect confirmation is supported');
        }

        return $confirmation->getConfirmationUrl();
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return [];
    }
}
