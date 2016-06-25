<?php

namespace zvook\Skrill\Models;

use zvook\Skrill\Components\AsArrayTrait;

/**
 * @package zvook\Skrill\Models
 * @author Dmitry zvook Klyukin
 * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf
 */
class QuickCheckout extends Model
{
    use AsArrayTrait;

    const URL_TARGET_TOP = 1;
    const URL_TARGET_PARENT = 2;
    const URL_TARGET_SELF = 3;
    const URL_TARGET_BLANK = 4;

    /**
     * Email address of your Skrill merchant account.
     *
     * @var string
     * @required true
     * @max-length 50
     */
    protected $pay_to_email;

    /**
     * The total amount payable.
     * Note : do not include the trailing zeroes if the amount is a natural number. For example: “ 23 ” (not “ 23.00 ”).
     *
     * @var int|float
     * @required true
     * @max-length 19
     */
    protected $amount;

    /**
     * 3 ‐ letter code of the currency of the amount according to ISO 4217
     *
     * @var string
     * @required true
     * @max-length 3
     * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf#M10.9.Toc385420915
     */
    protected $currency;

    /**
     * A description to be shown on the Skrill payment page in the logo area if there is no logo_url parameter.
     * If no value is submitted and there is no logo, the pay_to_email value is shown as the recipient of the payment.
     *
     * @var string
     * @required false
     * @max-length 30
     */
    protected $recipient_description = null;

    /**
     * Your unique reference or identification number for the transaction.
     * Must be unique for each payment.
     *
     * @var string
     * @required false
     * @max-length 100
     */
    protected $transaction_id = null;

    /**
     * URL to which the customer is returned once the payment is made.
     * If this field is not filled, the Skrill Quick Checkout page closes automatically at the end of the transaction
     * and the customer is returned to the page on your website from where they were redirected to Skrill.
     * A secure return URL option is available
     *
     * @var string
     * @required false
     * @max-length 240
     */
    protected $return_url = null;

    /**
     * The text on the button when the customer finishes their payment.
     *
     * @var string
     * @required false
     * @max-length 35
     */
    protected $return_url_text = null;

    /**
     * Specifies a target in which the return_url value is displayed upon successful payment from the customer.
     *
     * @var int
     * @required false
     * @default 1
     * @max-length 1
     */
    protected $return_url_target;

    /**
     * URL to which the customer is returned if the payment is cancelled or fails.
     * If no cancel URL is provided then the Cancel button is not displayed.
     *
     * @var string
     * @required false
     * @max-length 240
     */
    protected $cancel_url = null;

    /**
     * Specifies a target in which the cancel_url value is displayed upon cancellation of payment by the customer.
     *
     * @var int
     * @required false
     * @default 1
     * @max-length 1
     */
    protected $cancel_url_target;

    /**
     * URL to which the transaction details are posted after the payment process is complete.
     * Alternatively, you may specify an email address where the results are sent.
     * If the status_url is omitted, no transaction details are sent.
     *
     * @var string
     * @required false
     * @max-length 400
     */
    protected $status_url = null;

    /**
     * Second URL to which the transaction details are posted after the payment process is complete.
     * Alternatively, you may specify an email address where the results are sent.
     *
     * @var string
     * @required false
     * @max-length 400
     */
    protected $status_url2 = null;

    /**
     * 2 ‐ letter code of the language used for Skrill’s pages.
     * Accepted values: [BG, CS, DA, DE, EL, EN, ES, FI, FR, IT, ZH, NL, PL, RO, RU, SV, TR, JA]
     *
     * @var string
     * @required false
     * @default EN
     * @max-length 2
     */
    protected $language;

    /**
     * The URL of the logo which you would like to appear in the top right of the Skrill page.
     * The logo must be accessible via HTTPS or it will not be shown. The logo will be resized to fit.
     * To avoid scaling distortion, the minimum size should be as follows:
     * - If the logo width > height ‐ at least 107px width.
     * - If logo width > height ‐ at least 65px height.
     * Avoid large images (much greater than 256 by 256px) to minimise the page loading time.
     *
     * @var string
     * @required false
     * @max-length 240
     */
    protected $logo_url = null;

    /**
     * Forces only the SID to be returned without the actual page.
     * Useful when using the secure method to redirect the customer to Quick Checkout.
     * 0 => default
     * 1 => prepare only
     *
     * @var int
     * @required false
     * @default 0
     * @max-length 1
     * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf#G4.1034905
     */
    protected $prepare_only;

    /**
     * When a customer pays through Skrill, Skrill submits a preconfigured descriptor with the transaction,
     * containing your business trading name/ brand name.
     * The descriptor is typically displayed on the bank or credit card statement of the customer.
     * For Sofortuberweisung and Direct Debit payment methods, you can submit a dynamic_descriptor,
     * which will override the default value stored by Skrill.
     *
     * @var string
     * @required false
     * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf#M7.9.Toc396905694
     */
    protected $dynamic_descriptor = null;

    /**
     * This is an optional parameter containing the Session ID returned by the prepare_only call.
     * If you use this parameter then you should not supply any other parameters.
     *
     * @var string
     * @required false
     * @max-length 32
     */
    protected $sid = null;

    /**
     * You can pass a unique referral ID or email of an affiliate from which the customer is referred.
     * The rid value must be included within the actual payment request.
     *
     * @var string
     * @required false
     * @max-length 100
     */
    protected $rid = null;

    /**
     * You can pass additional identifier in this field in order to track your affiliates.
     * You must inform your account manager about the exact value that will be submitted
     * so that affiliates can be tracked.
     *
     * @var string
     * @required false
     * @max-length 100
     */
    protected $ext_ref_id = null;

    /**
     * A comma ‐ separated list of field names that are passed back to your web server when the payment is confirmed.
     * Maximum 5 fields
     *
     * @var string
     * @required false
     * @max-length 240
     */
    protected $merchant_fields = null;

    /**
     * Email address of the customer who is making the payment.
     * If provided, this field is hidden on the payment form.
     * If left empty, the customer has to enter their email address.
     *
     * @var string
     * @required false
     * @max-length 100
     */
    protected $pay_from_email = null;

    /**
     * Customer's first name
     *
     * @var string
     * @required false
     * @max-length 20
     */
    protected $firstname = null;

    /**
     * Customer's last name
     *
     * @var string
     * @required false
     * @max-length 50
     */
    protected $lastname = null;

    /**
     * Date of birth of the customer. The format is ddmmyyyy .
     * Only numeric values are accepted. If provided this field will be pre ‐ filled in the Payment form.
     * This saves time for ELV payments and Skrill Wallet sign ‐ up which require the customer to enter a date of birth.
     *
     * @var string
     * @required false
     * @max-length 8
     * @example 01121980
     */
    protected $date_of_birth = null;

    /**
     * Customer's address (e.g. street).
     *
     * @var string
     * @required false
     * @max-length 100
     */
    protected $address = null;

    /**
     * Customer's address (e.g. street).
     *
     * @var string
     * @required false
     * @max-length 100
     */
    protected $address2 = null;

    /**
     * Customer’s phone number. Only numeric values are accepted.
     *
     * @var string
     * @required false
     * @max-length 20
     */
    protected $phone_number = null;

    /**
     * Customer's postal code/ZIP Code. Only alphanumeric values are accepted (e.g., no punctuation marks or dashes)
     *
     * @var string
     * @required false
     * @max-length 9
     */
    protected $postal_code = null;

    /**
     * Customer's city or postal area
     *
     * @var string
     * @required false
     * @max-length 50
     */
    protected $city = null;

    /**
     * Customer's state or region
     *
     * @var string
     * @required false
     * @max-length 50
     */
    protected $state = null;

    /**
     * Customer’s country in the 3‐digit ISO Code
     *
     * @var string
     * @required false
     * @max-length 3
     * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf#M10.9.67055.heading.2.62.ISO.country.codes.3digit
     */
    protected $country = null;

    /**
     * You can include a calculation for the total amount payable, which is displayed in the More information section
     * in the header of the Skrill payment form. Note that Skrill does not check the validity of this data.
     *
     * @var string
     * @required false
     * @max-length 240
     */
    protected $amount2_description = null;

    /**
     * This amount in the currency defined in the field 'currency' will be shown next to amount2_description.
     *
     * @var int|float
     * @required false
     * @max-length 19
     */
    protected $amount2 = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see amount2_description
     */
    protected $amount3_description = null;

    /**
     * @var int|float
     * @required false
     * @max-length 19
     * @see amount2
     */
    protected $amount3 = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see amount2_description
     */
    protected $amount4_description = null;

    /**
     * @var int|float
     * @required false
     * @max-length 19
     * @see amount2
     */
    protected $amount4 = null;

    /**
     * You can show up to five additional details about the product in the More information section
     * in the header of Quick Checkout.
     *
     * @var string
     * @required false
     * @max-length 240
     */
    protected $detail1_description = null;

    /**
     * The detail1_text is shown next to the detail1_description in the More Information section
     * in the header of the payment form with the other payment details.
     * The detail1_description combined with the detail1_text is shown in the more information field
     * of the merchant account history CSV file. Using the example values, this would be Product ID: 4509334.
     * Note if a customer pays for a purchase using Skrill Wallet then this information will also appear
     * in the same field in their account history.
     *
     * @var string
     * @required false
     * @max-length 240
     */
    protected $detail1_text = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see detail1_description
     */
    protected $detail2_description = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see detail1_text
     */
    protected $detail2_text = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see detail1_description
     */
    protected $detail3_description = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see detail1_text
     */
    protected $detail3_text = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see detail1_description
     */
    protected $detail4_description = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see detail1_text
     */
    protected $detail4_text = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see detail1_description
     */
    protected $detail5_description = null;

    /**
     * @var string
     * @required false
     * @max-length 240
     * @see detail1_text
     */
    protected $detail5_text = null;

    /**
     * @param string $detail5_text
     * @return $this
     */
    public function setDetail5Text($detail5_text)
    {
        $this->detail5_text = $detail5_text;

        return $this;
    }

    /**
     * @param string $pay_to_email
     * @return $this
     */
    public function setPayToEmail($pay_to_email)
    {
        $this->pay_to_email = $pay_to_email;

        return $this;
    }

    /**
     * @param float|int $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @param string $recipient_description
     * @return $this
     */
    public function setRecipientDescription($recipient_description)
    {
        $this->recipient_description = $recipient_description;

        return $this;
    }

    /**
     * @param string $transaction_id
     * @return $this
     */
    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }

    /**
     * @param string $return_url
     * @return $this
     */
    public function setReturnUrl($return_url)
    {
        $this->return_url = $return_url;

        return $this;
    }

    /**
     * @param string $return_url_text
     * @return $this
     */
    public function setReturnUrlText($return_url_text)
    {
        $this->return_url_text = $return_url_text;

        return $this;
    }

    /**
     * @param int $return_url_target
     * @return $this
     */
    public function setReturnUrlTarget($return_url_target)
    {
        $this->return_url_target = $return_url_target;

        return $this;
    }

    /**
     * @param string $cancel_url
     * @return $this
     */
    public function setCancelUrl($cancel_url)
    {
        $this->cancel_url = $cancel_url;

        return $this;
    }

    /**
     * @param int $cancel_url_target
     * @return $this
     */
    public function setCancelUrlTarget($cancel_url_target)
    {
        $this->cancel_url_target = $cancel_url_target;

        return $this;
    }

    /**
     * @param string $status_url
     * @return $this
     */
    public function setStatusUrl($status_url)
    {
        $this->status_url = $status_url;

        return $this;
    }

    /**
     * @param string $status_url2
     * @return $this
     */
    public function setStatusUrl2($status_url2)
    {
        $this->status_url2 = $status_url2;

        return $this;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param string $logo_url
     * @return $this
     */
    public function setLogoUrl($logo_url)
    {
        $this->logo_url = $logo_url;

        return $this;
    }

    /**
     * @param int $prepare_only
     * @return $this
     */
    public function setPrepareOnly($prepare_only)
    {
        $this->prepare_only = $prepare_only;

        return $this;
    }

    /**
     * @param string $dynamic_descriptor
     * @return $this
     */
    public function setDynamicDescriptor($dynamic_descriptor)
    {
        $this->dynamic_descriptor = $dynamic_descriptor;

        return $this;
    }

    /**
     * @param string $sid
     * @return $this
     */
    public function setSid($sid)
    {
        $this->sid = $sid;

        return $this;
    }

    /**
     * @param string $rid
     * @return $this
     */
    public function setRid($rid)
    {
        $this->rid = $rid;

        return $this;
    }

    /**
     * @param string $ext_ref_id
     * @return $this
     */
    public function setExtRefId($ext_ref_id)
    {
        $this->ext_ref_id = $ext_ref_id;

        return $this;
    }

    /**
     * @param string $merchant_fields
     * @return $this
     */
    public function setMerchantFields($merchant_fields)
    {
        $this->merchant_fields = $merchant_fields;

        return $this;
    }

    /**
     * @param string $pay_from_email
     * @return $this
     */
    public function setPayFromEmail($pay_from_email)
    {
        $this->pay_from_email = $pay_from_email;

        return $this;
    }

    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @param string $date_of_birth
     * @return $this
     */
    public function setDateOfBirth($date_of_birth)
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param string $address2
     * @return $this
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * @param string $phone_number
     * @return $this
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * @param string $postal_code
     * @return $this
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param string $amount2_description
     * @return $this
     */
    public function setAmount2Description($amount2_description)
    {
        $this->amount2_description = $amount2_description;

        return $this;
    }

    /**
     * @param float|int $amount2
     * @return $this
     */
    public function setAmount2($amount2)
    {
        $this->amount2 = $amount2;

        return $this;
    }

    /**
     * @param string $amount3_description
     * @return $this
     */
    public function setAmount3Description($amount3_description)
    {
        $this->amount3_description = $amount3_description;

        return $this;
    }

    /**
     * @param float|int $amount3
     * @return $this
     */
    public function setAmount3($amount3)
    {
        $this->amount3 = $amount3;

        return $this;
    }

    /**
     * @param string $amount4_description
     * @return $this
     */
    public function setAmount4Description($amount4_description)
    {
        $this->amount4_description = $amount4_description;

        return $this;
    }

    /**
     * @param float|int $amount4
     * @return $this
     */
    public function setAmount4($amount4)
    {
        $this->amount4 = $amount4;

        return $this;
    }

    /**
     * @param string $detail1_description
     * @return $this
     */
    public function setDetail1Description($detail1_description)
    {
        $this->detail1_description = $detail1_description;

        return $this;
    }

    /**
     * @param string $detail1_text
     * @return $this
     */
    public function setDetail1Text($detail1_text)
    {
        $this->detail1_text = $detail1_text;

        return $this;
    }

    /**
     * @param string $detail2_description
     * @return $this
     */
    public function setDetail2Description($detail2_description)
    {
        $this->detail2_description = $detail2_description;

        return $this;
    }

    /**
     * @param string $detail2_text
     * @return $this
     */
    public function setDetail2Text($detail2_text)
    {
        $this->detail2_text = $detail2_text;

        return $this;
    }

    /**
     * @param string $detail3_description
     * @return $this
     */
    public function setDetail3Description($detail3_description)
    {
        $this->detail3_description = $detail3_description;

        return $this;
    }

    /**
     * @param string $detail3_text
     * @return $this
     */
    public function setDetail3Text($detail3_text)
    {
        $this->detail3_text = $detail3_text;

        return $this;
    }

    /**
     * @param string $detail4_description
     * @return $this
     */
    public function setDetail4Description($detail4_description)
    {
        $this->detail4_description = $detail4_description;

        return $this;
    }

    /**
     * @param string $detail4_text
     * @return $this
     */
    public function setDetail4Text($detail4_text)
    {
        $this->detail4_text = $detail4_text;

        return $this;
    }

    /**
     * @param string $detail5_description
     * @return $this
     */
    public function setDetail5Description($detail5_description)
    {
        $this->detail5_description = $detail5_description;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayToEmail()
    {
        return $this->pay_to_email;
    }

    /**
     * @return float|int
     */
    public function getAmount()
    {
        return $this->amount;
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
    public function getRecipientDescription()
    {
        return $this->recipient_description;
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
    public function getReturnUrl()
    {
        return $this->return_url;
    }

    /**
     * @return string
     */
    public function getReturnUrlText()
    {
        return $this->return_url_text;
    }

    /**
     * @return int
     */
    public function getReturnUrlTarget()
    {
        return $this->return_url_target;
    }

    /**
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->cancel_url;
    }

    /**
     * @return int
     */
    public function getCancelUrlTarget()
    {
        return $this->cancel_url_target;
    }

    /**
     * @return string
     */
    public function getStatusUrl()
    {
        return $this->status_url;
    }

    /**
     * @return string
     */
    public function getStatusUrl2()
    {
        return $this->status_url2;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
        return $this->logo_url;
    }

    /**
     * @return int
     */
    public function getPrepareOnly()
    {
        return $this->prepare_only;
    }

    /**
     * @return string
     */
    public function getDynamicDescriptor()
    {
        return $this->dynamic_descriptor;
    }

    /**
     * @return string
     */
    public function getSid()
    {
        return $this->sid;
    }

    /**
     * @return string
     */
    public function getRid()
    {
        return $this->rid;
    }

    /**
     * @return string
     */
    public function getExtRefId()
    {
        return $this->ext_ref_id;
    }

    /**
     * @return string
     */
    public function getMerchantFields()
    {
        return $this->merchant_fields;
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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getAmount2Description()
    {
        return $this->amount2_description;
    }

    /**
     * @return float|int
     */
    public function getAmount2()
    {
        return $this->amount2;
    }

    /**
     * @return string
     */
    public function getAmount3Description()
    {
        return $this->amount3_description;
    }

    /**
     * @return float|int
     */
    public function getAmount3()
    {
        return $this->amount3;
    }

    /**
     * @return string
     */
    public function getAmount4Description()
    {
        return $this->amount4_description;
    }

    /**
     * @return float|int
     */
    public function getAmount4()
    {
        return $this->amount4;
    }

    /**
     * @return string
     */
    public function getDetail1Description()
    {
        return $this->detail1_description;
    }

    /**
     * @return string
     */
    public function getDetail1Text()
    {
        return $this->detail1_text;
    }

    /**
     * @return string
     */
    public function getDetail2Description()
    {
        return $this->detail2_description;
    }

    /**
     * @return string
     */
    public function getDetail2Text()
    {
        return $this->detail2_text;
    }

    /**
     * @return string
     */
    public function getDetail3Description()
    {
        return $this->detail3_description;
    }

    /**
     * @return string
     */
    public function getDetail3Text()
    {
        return $this->detail3_text;
    }

    /**
     * @return string
     */
    public function getDetail4Description()
    {
        return $this->detail4_description;
    }

    /**
     * @return string
     */
    public function getDetail4Text()
    {
        return $this->detail4_text;
    }

    /**
     * @return string
     */
    public function getDetail5Description()
    {
        return $this->detail5_description;
    }

    /**
     * @return string
     */
    public function getDetail5Text()
    {
        return $this->detail5_text;
    }
}