<?php

namespace Omnipay\Billplz\Message;

/**
 * Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{

    protected function createResponse($data, $statusCode)
    {
        return $this->response = new PurchaseResponse($this, $data, $statusCode);
    }

    public function getHttpMethod() {
        return 'POST';
    }

    public function getAPI() {
        return 'bills';
    }

    public function getData() {
        $data = [];

        $data['collection_id'] = $this->getParameter('collectionId');
        $data['description'] = $this->getParameter('description');
        $data['email'] = $this->getParameter('email');
        $data['name'] = $this->getParameter('name');
        $data['amount'] = $this->getParameter('amount');
        $data['callback_url'] = $this->getParameter('notifyUrl');

        return $data;
    }

}
