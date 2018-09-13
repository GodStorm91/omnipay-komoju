<?php
/**
 * Komoju Abstract Request
 */

namespace Omnipay\Komoju\Message;
/**
 * Komoju Abstract Request
 *
 * @see  \Omnipay\Komoju\Gateway
 * @link https://docs.komoju.com
 * @method \Omnipay\Komoju\Message\Response send()
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /**
     * The live API endpoint.
     *
     * @var string
     */
    protected $liveUrl = 'https://komoju.com';
    /**
     * The test API endpoint.
     *
     * @var string
     */
    protected $testUrl = 'https://sandbox.komoju.com';

    /**
     * Get the API Key
     *
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set the API Key
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * Get the customer family name
     * @return mixed
     */
    public function getCustomerFamilyName()
    {
        return $this->getParameter('customerFamilyName');
    }

    /**
     * Set customer family name
     * @param $value
     * @return mixed
     */
    public function setCustomerFamilyName($value)
    {
        return $this->setParameter('customerFamilyName', $value);
    }

    /**
     * Get the customer family name kana
     * @return mixed
     */
    public function getCustomerFamilyNameKana()
    {
        return $this->getParameter('customerFamilyNameKana');
    }

    /**
     * Set customer family name kana
     * @param $value
     * @return mixed
     */
    public function setCustomerFamilyNameKana($value)
    {
        return $this->setParameter('customerFamilyNameKana', $value);
    }

    /**
     * Get the customer given name
     * @return mixed
     */
    public function getCustomerGivenName()
    {
        return $this->getParameter('customerGivenName');
    }

    /**
     * Set customer given name
     * @param $value
     * @return mixed
     */
    public function setCustomerGivenName($value)
    {
        return $this->setParameter('customerGivenName', $value);
    }

    /**
     * Get the customer given name kana
     * @return mixed
     */
    public function getCustomerGivenNameKana()
    {
        return $this->getParameter('customerGivenNameKana');
    }

    /**
     * Set customer given name kana
     * @param $value
     * @return mixed
     */
    public function setCustomerGivenNameKana($value)
    {
        return $this->setParameter('customerGivenNameKana', $value);
    }

    /**
     * Get the email
     *
     * @return mixed
     */
    public function getCustomerEmail()
    {
        return $this->getParameter('customerEmail');
    }

    /**
     * Set the email
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setCustomerEmail($value)
    {
        return $this->setParameter('customerEmail', $value);
    }

    /**
     * Get the customer phone
     *
     * @return mixed
     */
    public function getCustomerPhone()
    {
        return $this->getParameter('customerPhone');
    }

    /**
     * Set the customer phone
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setCustomerPhone($value)
    {
        return $this->setParameter('customerPhone', $value);
    }

    /**
     * Get the tax.
     *
     * @return mixed
     */
    public function getTax()
    {
        return $this->getParameter('tax');
    }

    /**
     * Set the tax.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setTax($value)
    {
        return $this->setParameter('tax', $value);
    }

    /**
     * Get the account ID.
     *
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->getParameter('accountId');
    }

    /**
     * Set the account ID.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setAccountId($value)
    {
        return $this->setParameter('accountId', $value);
    }

    /**
     * Get the payment method.
     *
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    /**
     * Set the payment method.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }

    /**
     * Get the locale.
     *
     * @return mixed
     */
    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    /**
     * Set the locale.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Get the timestamp.
     *
     * @return mixed
     */
    public function getTimestamp()
    {
        $timestamp = $this->getParameter('timestamp');
        return !empty($timestamp) ? $timestamp : time();
    }

    /**
     * Set the timestamp.
     *
     * @param $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setTimestamp($value)
    {
        return $this->setParameter('timestamp', $value);
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        $params = array();
        foreach ($data as $key => $val) {
            $params[] = urlencode($key) . '=' . urlencode($val);
        }
        sort($params);
        $queryString = implode('&', $params);
        $endpoint = $this->getEndpoint() . '?' . $queryString;
        $hmac = hash_hmac('sha256', $endpoint, $this->getApiKey());
        $url = $this->getBaseUrl() . $endpoint . '&hmac=' . $hmac;
        return $this->response = new PurchaseResponse($this, $data, $url);
    }

    /**
     * Retrieve the appropriate base URL.
     *
     * @return string
     */
    protected function getBaseUrl()
    {
        return $this->getTestMode() ? $this->testUrl : $this->liveUrl;
    }

    /**
     * Generate the endpoint based on the current options.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        $locale = $this->getLocale();
        $account = $this->getAccountId();
        $method = $this->getPaymentMethod();
        return '/' . $locale . '/api/' . $account . '/transactions/' . $method . '/new';
    }
}