# PHP package for Skrill QuickCheckout interface

[![Latest Stable Version](https://poser.pugx.org/zvook/php-skrill-quick-checkout/v/stable)](https://packagist.org/packages/zvook/php-skrill-quick-checkout)
[![Total Downloads](https://poser.pugx.org/zvook/php-skrill-quick-checkout/downloads)](https://packagist.org/packages/zvook/php-skrill-quick-checkout)

### Installation

```json
{
  "require": {
    "zvook/php-skrill-quick-checkout": "^2"
  }
}
```

### Usage

```php
use Xaerobiont\Skrill\QuickCheckout;
use Xaerobiont\Skrill\PaymentProcessor;

$qc = new QuickCheckout([
    'pay_to_email' => 'mymoneybank@mail.com',
    'amount' => 100500,
    'currency' => 'EUR'
]);

$qc->setReturnUrl('https://my-domain.com')
    ->setStatusUrl('https://my-domain.com/listen-skrill')
    ->setReturnUrlTarget(QuickCheckout::URL_TARGET_BLANK);
// See QuickCheckout class to find complete list of parameters

$api = new PaymentProcessor($q);
$url = $api->getPaymentUrl();
// Redirect user to this URL
```

In your status listener

```php
use Xaerobiont\Skrill\StatusResponse;
use Xaerobiont\Skrill\SkrillException;

$data = $_POST;
$response = new StatusResponse($data, skipUndefined: true);

if (
    !$response->verifySignature('your Skrill secret word') || 
    $response->getPayToEmail() !== 'mymoneybank@mail.com'
) {
    // hm, angry hacker?
}

switch ((int)$response->getStatus()) {
    case StatusResponse::STATUS_PROCESSED:
        // Payment is done. You need to return anything with 200 http code, otherwise, Skrill will retry request
        break;
    case StatusResponse::STATUS_CANCELED:
    case StatusResponse::STATUS_CHARGEBACK:
    case StatusResponse::STATUS_PENDING:
        // Process other statuses
        break;
    case StatusResponse::STATUS_FAILED:
        // Note that you should enable receiving failure code in Skrill account
        $errorCode = $data['failed_reason_code'];
        
// Note that StatusResponse contains parameters required for signature validation only.
// Check $_POST to find all of them
}
```

### Information

- Based on Skrill API version - **8.1**
- [Skrill QuickCheckout documentation](https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf)
- Skrill test merchant email: **demoqco@sun-fish.com**
- Skrill test card numbers: VISA: **4000001234567890** MASTERCARD: **5438311234567890**