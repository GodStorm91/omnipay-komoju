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

    protected $data;

    /**
     * PurchaseResponse constructor.
     * @param RequestInterface $request
     * @param $data
     */

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return true;
    }

    /**
     * Payment will be consider as a pending status. Additional webhook request will update detail payment status later
     *
     * @return bool
     */
    public function isPending()
    {
        return true;
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
