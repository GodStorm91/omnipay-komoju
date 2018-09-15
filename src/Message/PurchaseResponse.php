<?php
/**
 * Komoju Response
 */

namespace Omnipay\Komoju\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

/*
 * Sample response object:
 :---------------------:credit_card:---------------------:
array (
  'id' => '3dbxep0m999khw1np0oj6n2n9',
  'resource' => 'payment',
  'status' => 'captured',
  'amount' => 1000,
  'tax' => 1,
  'customer' => NULL,
  'payment_deadline' => '2018-09-22T14:59:59Z',
  'payment_details' =>
  array (
    'type' => 'credit_card',
    'email' => 'huanvn@gmail.com',
    'brand' => 'master',
    'last_four_digits' => '4444',
    'month' => 10,
    'year' => 2022,
  ),
  'payment_method_fee' => 0,
  'total' => 1001,
  'currency' => 'JPY',
  'description' => NULL,
  'captured_at' => '2018-09-15T12:50:51Z',
  'external_order_num' => NULL,
  'metadata' =>
  array (
  ),
  'created_at' => '2018-09-15T12:50:50Z',
  'amount_refunded' => 0,
  'locale' => 'ja',
  'refunds' =>
  array (
  ),
  'refund_requests' =>
  array (
  ),
)
:---------------------:konbini:---------------------:
{
   "customer" : null,
   "payment_method_fee" : 185,
   "description" : null,
   "created_at" : "2018-09-14T18:16:47Z",
   "amount_refunded" : 0,
   "status" : "authorized",
   "refunds" : [],
   "payment_deadline" : "2018-09-18T14:59:59Z",
   "metadata" : {},
   "payment_details" : {
    "store" : "seven-eleven",
      "confirmation_code" : null,
      "type" : "konbini",
      "receipt" : "gcn9726ysy",
      "email" : "huanvn@gmail.com",
      "instructions_url" : "https://komoju.com/ja/instructions/axs20a6iu0a8rbthyycq13sq8"
   },
   "locale" : "ja",
   "id" : "axs20a6iu0a8rbthyycq13sq8",
   "total" : 1265,
   "currency" : "JPY",
   "resource" : "payment",
   "tax" : 80,
   "amount" : 1000,
   "external_order_num" : null,
   "refund_requests" : [],
   "captured_at" : null
}
*/

/**
 * Komoju Response
 *
 * This is the response class for payment requests with token.
 *
 * @see \Omnipay\Komoju\Gateway
 */
class PurchaseResponse extends AbstractResponse
{
    const STATUS_AUTHORIZED = "authorized";
    const STATUS_CAPTURED = "captured";

    protected $request;
    protected $header;
    protected $data;

    /**
     * PurchaseResponse constructor.
     * @param RequestInterface $request
     * @param $header
     * @param $data
     */
    public function __construct(RequestInterface $request, $header, $data)
    {
        $this->request = $request;
        $this->header = $header;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        // https://docs.komoju.com/en/api/overview/#http_status_codes
        return isset($this->header['http_code']) && $this->header['http_code'] < 400;
    }

    /**
     * A success request will return payment as Authorized or Captured
     *
     * @return bool
     */
    public function isPending()
    {
        return isset($this->data['status']) ?  $this->data['status'] != PurchaseResponse::STATUS_CAPTURED : false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    public function getTransactionReference()
    {
        return isset($this->data['id']) ? $this->data['id'] : '';
    }
}
