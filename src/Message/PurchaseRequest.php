<?php
/**
 * Komoju Purchase Request
 */

namespace Omnipay\Komoju\Message;

use Omnipay\Common\Http\Exception;

/**
 * Komoju Purchase Request
 *
 * @see \Omnipay\Komoju\Gateway
 * @link https://docs.komoju.com/api/resources/payments
 */
class PurchaseRequest extends AbstractRequest
{
    const PAYMENT_API_URL = 'https://komoju.com/api/v1/payments';

    protected $requestHeader;

    /**
     * @return array|mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency');
        $data = array();
        $data['timestamp'] = $this->getTimestamp();
        $data['transaction[amount]'] = $this->getAmountInteger();
        $data['transaction[currency]'] = strtoupper($this->getCurrency());

        if ($this->getToken()) {
            $data['transaction[token]'] = $this->getToken();
        } else {
            $data['transaction[external_order_num]'] = $this->getTransactionReference();
            $data['transaction[tax]'] = $this->getTax();
            $data['transaction[cancel_url]'] = $this->getCancelUrl();
            $data['transaction[return_url]'] = $this->getReturnUrl();
            $data['transaction[customer][given_name]'] = $this->getCustomerGivenName();
            $data['transaction[customer][given_name_kana]'] = $this->getCustomerFamilyNameKana();
            $data['transaction[customer][family_name]'] = $this->getCustomerFamilyName();
            $data['transaction[customer][family_name_kana]'] = $this->getCustomerFamilyNameKana();
            $data['transaction[customer][email]'] = $this->getCustomerEmail();
            $data['transaction[customer][phone]'] = $this->getCustomerPhone();
        }

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data
     * @return \Omnipay\Common\Message\ResponseInterface|PurchaseResponse
     */
    public function sendData($data)
    {
        if ($this->getToken()) {
            return $this->createResponse($data);
        } else {
            return $this->createHostedGatewayResponse($data);
        }
    }

    private function createResponse()
    {
        $params = [
            'amount' => $this->getAmountInteger(),
            'currency' => $this->getCurrency(),
            'payment_details' => $this->getToken(),
        ];
        $apiKey = $this->getApiKey();

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, PurchaseRequest::PAYMENT_API_URL);
            curl_setopt($ch, CURLOPT_USERPWD, "$apiKey:");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $result = curl_exec($ch);

            $header = curl_getinfo($ch);
            $body = json_decode($result, true);
            return $this->response = new PurchaseResponse($this, $header, $body);
        } catch (Exception $ex) {
            $error = ['error' => [
                'code' => 'bad_request',
                'message' => $ex->getMessage(),
                'param' => '',
            ]];
            return $this->response = new PurchaseResponse($this, ['http_code' => 500], $error);
        }
    }

    private function createHostedGatewayResponse($data)
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
        return $this->response = new HostedGatewayResponse($this, $data, $url);
    }
}