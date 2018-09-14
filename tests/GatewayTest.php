<?php

namespace Omnipay\Komoju;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var \Omnipay\Komoju\Gateway
     */
    protected $gateway;

    /**
     * Set up the GatewayTest sandbox.
     */
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * This tests the gateway's ability to generate a proper request.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function testPurchase()
    {
        $timestamp = time();
        $request = $this->gateway->purchase(array(
            'amount' => '130',
            'customer_family_name' => 'John',
            'customer_family_name_kana' => 'John',
            'customer_given_name' => 'Smith',
            'customer_given_name_kana' => 'Smith',
            'customer_email' => 'test@email.com',
            'customer_phone' => '0123456789',
            'cancel_url' => 'http://www.google.com',
            'return_url' => 'http://www.yahoo.com',
            'currency' => 'JPY',
            'tax' => '0',
            'transactionReference' => '1',
            'timestamp' => $timestamp
        ));
        $this->assertInstanceOf('\Omnipay\Komoju\Message\PurchaseRequest', $request);
        $this->assertSame('130', $request->getAmount());
        $this->assertSame('John', $request->getCustomerFamilyName());
        $this->assertSame('John', $request->getCustomerFamilyNameKana());
        $this->assertSame('Smith', $request->getCustomerGivenName());
        $this->assertSame('Smith', $request->getCustomerGivenNameKana());
        $this->assertSame('test@email.com', $request->getCustomerEmail());
        $this->assertSame('0123456789', $request->getCustomerPhone());
        $this->assertSame('http://www.google.com', $request->getCancelUrl());
        $this->assertSame('http://www.yahoo.com', $request->getReturnUrl());
        $this->assertSame('JPY', $request->getCurrency());
        $this->assertSame('0', $request->getTax());
        $this->assertSame('1', $request->getTransactionReference());
        $this->assertSame($timestamp, $request->getTimestamp());
    }
}