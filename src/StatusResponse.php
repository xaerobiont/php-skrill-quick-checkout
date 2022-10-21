<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

/**
 * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf
 */
class StatusResponse extends Model implements StatusResponseInterface
{
    const STATUS_PROCESSED = 2;
    const STATUS_FAILED = -2;
    const STATUS_PENDING = 0;
    const STATUS_CANCELED = -1;
    const STATUS_CHARGEBACK = -3;

    /**
     * Your email address.
     */
    protected string $pay_to_email;

    /**
     * Email address of the customer who is making the payment.
     * Note if a Skrill wallet account exists with this email and the Skrill Wallet is one of the available
     * payment method tabs then it will be selected as the default payment method.
     */
    protected string $pay_from_email;

    /**
     * Unique ID of your Skrill account. ONLY needed for the calculation of the MD5 signature.
     */
    protected mixed $merchant_id;

    /**
     * Transaction ID provided by your request.
     * If no transaction_id has submitted, the mb_transaction_id value will be here.
     */
    protected mixed $transaction_id = null;

    /**
     * The total amount of the payment in the currency of your merchant Skrill digital wallet account.
     */
    protected mixed $mb_amount;

    /**
     * Currency of mb_amount . Will always be the same as the currency of your merchant Skrill digital wallet account.
     */
    protected string $mb_currency;

    /**
     * Status of the transaction
     */
    protected mixed $status;

    /**
     * MD5 signature
     */
    protected string $md5sig;

    /**
     * You can find your secret word in Skrill account
     * Returns whether the Skrill response valid
     */
    public function verifySignature(string $secretWord): bool
    {
        $digest = strtoupper(md5(implode('', [
            $this->getMerchantId(),
            $this->getTransactionId(),
            strtoupper(md5($secretWord)),
            $this->getMbAmount(),
            $this->getMbCurrency(),
            $this->getStatus(),
        ])));

        return $digest === $this->getMd5sig();
    }

    public function getPayToEmail(): string
    {
        return $this->pay_to_email;
    }

    public function getPayFromEmail(): string
    {
        return $this->pay_from_email;
    }

    public function getMerchantId(): mixed
    {
        return $this->merchant_id;
    }

    public function getTransactionId(): mixed
    {
        return $this->transaction_id;
    }

    public function getMbAmount(): mixed
    {
        return $this->mb_amount;
    }

    public function getMbCurrency(): string
    {
        return $this->mb_currency;
    }

    public function getStatus(): mixed
    {
        return $this->status;
    }

    public function getMd5sig(): string
    {
        return $this->md5sig;
    }
}