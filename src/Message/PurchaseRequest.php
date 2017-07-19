<?php

namespace Omnipay\Billplz\Message;

/**
 * Purchase Request
 */
class PurchaseRequest extends AuthorizeRequest
{
    public function getTransactionType()
    {
        return 'sale';
    }
}
