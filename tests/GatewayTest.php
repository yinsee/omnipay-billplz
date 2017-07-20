<?php

namespace Omnipay\Billplz;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\Billplz\Gateway;
use Omnipay\Common\Exception\InvalidRequestException;

class GatewayTest extends GatewayTestCase
{
  /**
   * @var Omnipay/Billplz/SystemGateway
   */
    public $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        // tbd.
    }

}
