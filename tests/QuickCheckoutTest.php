<?php

namespace Xaerobiont\Skrill\Tests;

use PHPUnit\Framework\TestCase;
use Xaerobiont\Skrill\PaymentProcessor;
use Xaerobiont\Skrill\QuickCheckout;
use Xaerobiont\Skrill\StatusResponse;

final class QuickCheckoutTest extends TestCase
{
    public function testRequest()
    {
        $q = new QuickCheckout();
        $q->setAmount(10)
            ->setCurrency('EUR')
            ->setPayToEmail($_ENV['skrill_test_email']);

        $api = new PaymentProcessor($q);
        $url = $api->getPaymentUrl();
        self::assertNotEmpty($url);
    }

    public function testResponse()
    {
        $response = new StatusResponse([
            'pay_to_email' => $_ENV['skrill_test_email'],
            'pay_from_email' => 'some@mail.com',
            'merchant_id' => 999,
            'status' => StatusResponse::STATUS_PROCESSED,
            'transaction_id' => 'xoisodi77333',
            'mb_amount' => 10,
            'mb_currency' => 'EUR',
            'md5sig' => 'abdbdbd',
        ]);

        self::assertFalse($response->verifySignature($_ENV['skrill_test_secret']));
    }
}