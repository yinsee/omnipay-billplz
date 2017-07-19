<?php

namespace Omnipay\Billplz\Message;

/**
 * Capture Request
 */
class CaptureRequest extends AuthorizeRequest
{
    public function getTransactionType()
    {
        return 'capture';
    }
}
