<?php

namespace zvook\Skrill\Models;

use zvook\Skrill\Components\AsArrayTrait;
use zvook\Skrill\Components\SkrillException;

/**
 * @package zvook\Skrill\Models
 * @author Dmitry zvook Klyukin
 * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf#G4.1035703
 */
class SkrillStatusResponse extends Model
{
    const STATUS_PROCESSED = 2;
    const STATUS_FAILED = -2;
    const STATUS_PENDING = 0;
    const STATUS_CANCELED = -1;
    const STATUS_CHARGEBACK = -3;

    use AsArrayTrait;

    /**
     * Raw request from Skrill
     * @var array
     */
    private $raw = [];

    /**
     * Your email address.
     *
     * @var string
     * @required true
     */
    protected $pay_to_email;

    /**
     * Email address of the customer who is making the payment.
     * Note if a Skrill wallet account exists with this email and the Skrill Wallet is one of the available
     * payment method tabs then it will be selected as the default payment method.
     *
     * @var string
     * @required true
     */
    protected $pay_from_email;

    /**
     * Unique ID of your Skrill account. ONLY needed for the calculation of the MD5 signature.
     *
     * @var string
     * @required true
     */
    protected $merchant_id;

    /**
     * Transaction ID provided by your request.
     * If no transaction_id has submitted, the mb_transaction_id value will be here.
     *
     * @var string
     * @required true
     */
    protected $transaction_id;

    /**
     * Skrill's internal unique reference ID for this transaction.
     *
     * @var string
     * @required true
     */
    protected $mb_transaction_id;

    /**
     * Amount of the payment as posted in HTML form
     *
     * @var int|float
     * @required true
     */
    protected $amount;

    /**
     * The total amount of the payment in the currency of your merchant Skrill digital wallet account.
     *
     * @var int|float
     * @required true
     */
    protected $mb_amount;

    /**
     * Amount of the amount as posted in HTML form
     *
     * @var string
     * @required true
     */
    protected $currency;

    /**
     * Currency of mb_amount . Will always be the same as the currency of your merchant Skrill digital wallet account.
     *
     * @var string
     * @required true
     */
    protected $mb_currency;

    /**
     * Status of the transaction
     *
     * @var int
     * @required true
     */
    protected $status;

    /**
     * MD5 signature
     *
     * @var string
     * @required true
     * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf#M10.9.97017.heading.2.63.MD5.signature
     */
    protected $md5sig;

    /**
     * SHA2 signature
     *
     * @var string
     * @required true
     * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf#M10.9.75080.heading.2.64.SHA2.signature
     */
    protected $sha2sig;

    /**
     * @param array $params
     * @throws SkrillException
     */
    function __construct(array $params)
    {
        if (empty($params)) {
            throw new SkrillException('Request is empty');
        }

        $this->raw = $params;
        parent::__construct($params, true);
    }

    /**
     * @return array
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @return string
     */
    public function getPayToEmail()
    {
        return $this->pay_to_email;
    }

    /**
     * @return string
     */
    public function getPayFromEmail()
    {
        return $this->pay_from_email;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * @return string
     */
    public function getMbTransactionId()
    {
        return $this->mb_transaction_id;
    }

    /**
     * @return float|int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return float|int
     */
    public function getMbAmount()
    {
        return $this->mb_amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getMbCurrency()
    {
        return $this->mb_currency;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMd5sig()
    {
        return $this->md5sig;
    }

    /**
     * @return string
     */
    public function getSha2sig()
    {
        return $this->sha2sig;
    }

    /**
     * @return bool
     */
    public function isProcessed()
    {
        return $this->status == self::STATUS_PROCESSED;
    }

    /**
     * @return bool
     */
    public function isFailed()
    {
        return $this->status == self::STATUS_FAILED;
    }

    /**
     * @return bool
     */
    public function isCanceled()
    {
        return $this->status == self::STATUS_CANCELED;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isChargeBack()
    {
        return $this->status == self::STATUS_CHARGEBACK;
    }

    /**
     * You can find your secret word in Skrill account
     * Returns whether the Skrill response valid
     * @param $secretWord
     * @return bool
     */
    public function verifySignature($secretWord)
    {
        $digest = strtoupper(md5(implode('', [
            $this->getMerchantId(),
            $this->getTransactionId(),
            strtoupper(md5($secretWord)),
            $this->getMbAmount(),
            $this->getMbCurrency(),
            $this->getStatus()
        ])));

        return $digest == $this->getMd5sig();
    }

    /**
     * @param $targetPath
     * @return int
     */
    public function log($targetPath)
    {
        $log = date('d M y H:i:s', time());
        $log .= '| ' . json_encode($this->asArray()) . "\n\n";

        return file_put_contents($targetPath, $log, FILE_APPEND);
    }
}