# PHP5 package for Skrill QuickCheckout interface

[![Latest Stable Version](https://poser.pugx.org/zvook/php-skrill-quick-checkout/v/stable)](https://packagist.org/packages/zvook/php-skrill-quick-checkout)
[![Total Downloads](https://poser.pugx.org/zvook/php-skrill-quick-checkout/downloads)](https://packagist.org/packages/zvook/php-skrill-quick-checkout)
[![License](https://poser.pugx.org/zvook/php-skrill-quick-checkout/license)](https://packagist.org/packages/zvook/php-skrill-quick-checkout)

UNDER DEVELOPMENT
-----------------

Simple and useful PHP5 library to make payments via Skrill QuickCheckout interface

Containing:
- Payment model with each parameter description
- Payment form generator based on payment model
- Skrill status response model with signature verifier

### Installation

Add to your composer.json

```
"require": {
    "zvook/php-skrill-quick-checkout": "*"
}
```

And run

```sh
$ composer update
```

### Usage

```php
use zvook\Skrill\Models\QuickCheckout;

$quickCheckout = new QuickCheckout([
    'pay_to_email' => 'mymoneybank@mail.com',
    'amount' => 100500,
    'currency' => 'EUR'
]);

/*
You can also use setters to bind parameters to model
If you want to see all list of parameters just open QuickCheckout file
Each class attribute has description
*/
$quickCheckout->setReturnUrl('https://my-domain.com');
$quickCheckout->setReturnUrlTarget(QuickCheckout::URL_TARGET_BLANK);
```

Build and render form

```php
use zvook\Skrill\Models\QuickCheckoutForm;

$form = new QuickCheckoutForm($quickCheckout);

echo $form->open([
    'class' => 'skrill-form'
]);

/*
By default all fields will be rendered as hidden inputs
If you need to render some field as visible (i.e. amount of payment) you should specify it in $exclude
Excluded fields will not be rendered at all - you should render them by yourself
*/
$exclude = ['amount'];
echo $form->renderHidden($exclude);
<input type="text" name="amount"> .....
echo $form->renderSubmit('Pay', ['class' => 'btn']);
echo $form->close();
```

In your status_url listener:

```php
use zvook\Skrill\Models\SkrillStatusResponse;
use zvook\Skrill\Components\SkrillException;

try {
    $response = new SkrillStatusResponse($_POST);
} catch (SkrillException $e) {
    # something bad in request
}

if ($response->verifySignature('your Skrill secret word') && $response->isProcessed()) {
    # bingo! You need to return anything with 200 OK code! Otherwise, Skrill will retry request
}

# Or:

if ($response->isFailed()) {
    # Note that you should enable receiving failure code in Skrill account before
    # It will not provided with default settings
    $errorCode = $response->getFailedReasonCode();
}

/*
Also you can retrieve any Skrill response parameter and make extra validation you want.
To see all Skrill response parameters just view SkrillStatusResponse class attributes
For example:
*/
if ($response->getPayToEmail() !== 'mymoneybank@mail.com') {
    // hum, it's very strange ...
}
```

### Information

- Based on Skrill API version - **7.4**
- [Skrill QuickCheckout documentation](https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf)