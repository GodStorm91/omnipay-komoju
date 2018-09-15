<?php
/**
 * Komoju Gateway
 */

namespace Omnipay\Komoju;

use Omnipay\Common\AbstractGateway;

/**
 * Komoju Gateway
 *
 * @see \Omnipay\Common\AbstractGateway
 * @see \Omnipay\Komoju\Message\AbstractRequest
 * @link https://docs.komoju.com/
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Komoju';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
            'accountId' => '',
            'token' => '',
            'paymentMethod' => 'credit_card',
            'testMode' => true,
            'locale' => 'ja'
        );
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getToken()
    {
        return $this->getParameter('token');
    }

    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    public function getCustomerFamilyName()
    {
        return $this->getParameter('customerFamilyName');
    }

    public function setCustomerFamilyName($value)
    {
        return $this->setParameter('customerFamilyName', $value);
    }

    public function getCustomerFamilyNameKana()
    {
        return $this->getParameter('customerFamilyNameKana');
    }

    public function setCustomerFamilyNameKana($value)
    {
        return $this->setParameter('customerFamilyNameKana', $value);
    }

    public function getCustomerGivenName()
    {
        return $this->getParameter('customerGivenName');
    }

    public function setCustomerGivenName($value)
    {
        return $this->setParameter('customerGivenName', $value);
    }

    public function getCustomerGivenNameKana()
    {
        return $this->getParameter('customerGivenNameKana');
    }

    public function setCustomerGivenNameKana($value)
    {
        return $this->setParameter('customerGivenNameKana', $value);
    }

    public function getCustomerEmail()
    {
        return $this->getParameter('customerEmail');
    }

    public function setCustomerEmail($value)
    {
        return $this->setParameter('customerEmail', $value);
    }

    public function getCustomerPhone()
    {
        return $this->getParameter('customerPhone');
    }

    public function setCustomerPhone($value)
    {
        return $this->setParameter('customerPhone', $value);
    }

    public function getTax()
    {
        return $this->getParameter('tax');
    }

    public function setTax($value)
    {
        return $this->setParameter('tax', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Komoju\Message\PurchaseRequest', $parameters);
    }
}