# Omnipay: Billplz
[![Build Status](https://travis-ci.org/yinsee/omnipay-billplz.svg?branch=master)](https://travis-ci.org/yinsee/omnipay-billplz)

**(Unofficial) Billplz driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements MOLPay support for Omnipay.

[Billplz](http://www.billplz.com) is a payment gateway offering from Billplz Sdn Bhd. 
This package follows the **Billplz API v3** at http://www.billplz.com/api.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
    "require": {
        "yinsee/omnipay-billplz": "^2.0"
    }
```

and repositories
```json
    "repositories": {
        "omnipay-billplz": {
            "type": "vcs",
            "url": "https://github.com/yinsee/omnipay-billplz"
        }
    }
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Collection & Bill
Each payment is a `Bill`, which is under a `Collection`. To begin, you need to register at Billplz and create a collection, then retrieve the `CollectionId` for gateway setup.

## Example

### Create a purchase request
https://billplz.com/api#create-a-bill24

The example below explains how you can create a Bill using a Collection, then redirect user to the payment page.

```php
$gateway = Omnipay::create('Billplz');

$gateway->setAPIKey('73eb57f0-7d4e-42b9-a544-aeac6e4b0f81');
$gateway->setCollectionId('idbmmepb');
$gateway->setTestMode(1); // use sandbox mode for testing

$amount = 29.99; 

$options = [
      'returnUrl' => 'http://yoursite.com/paymentreturn',

      // billplz callback url
      'notifyUrl' => 'http://yoursite.com/paymentnotify',

      // other payment data
      'name'  => 'Purchase from Online Store',
      'description' => 'Order Reference #12345',
      'amount' => intval($amount*100),

      // customer info
      'name' => 'TAN YIN SEE',
      'email' => 'user@email.com',
];

$response = $gateway->purchase($options)->send();
if ($response->isSuccessful()) {
    // this will not happen
} elseif ($response->isRedirect()) {
    // redirect to offsite payment gateway

    // match and save the billId to your order table
    $billId = $response->getData()['id'];
    
    $response->redirect();
} else {
    // API failed: display message to customer
}
```

### Handling Callback
https://billplz.com/api#basic-callback_url

When the user submit the payment form, the gateway will use webhook to invoke the notifyUrl that you have specified. 

The code below gives an example how to handle the callback from server:

```php
if (isset($_REQUEST['id']) && isset($_REQUEST['state'])) {

  // look up your order by billId
  $billId = $_REQUEST['id'];
  
  if ($_REQUEST['paid']=="true") {
      // order completed
  }
  else {
      // order failed
  }
  
}
```


### To manually retrieve payment status
https://billplz.com/api#v3-get-a-bill25

The code below gives an example how to manually query the bill status from server:

```php
$response = $gateway->completePurchase(['id'=>$billId])->send();

if ($response->isSuccessful()) {
    // Paid
} else {
    // Not paid
}
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/yinsee/omnipay-billplz/issues),
or better yet, fork the library and submit a pull request.
