<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

/**
 * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf
 */
class QuickCheckout extends DTO implements QuickCheckoutInterface
{
    const URL_TARGET_TOP = 1;
    const URL_TARGET_PARENT = 2;
    const URL_TARGET_SELF = 3;
    const URL_TARGET_BLANK = 4;

    /**
     * Email address of your Skrill merchant account.
     *
     * @required true
     * @max-length 50
     */
    protected string $pay_to_email;

    /**
     * The total amount payable.
     * Note : do not include the trailing zeroes if the amount is a natural number. I.e. 23 instead of 23.00
     *
     * @required true
     * @max-length 19
     */
    protected int|float $amount;

    /**
     * 3 ‐ letter code of the currency of the amount according to ISO 4217
     *
     * @required true
     * @max-length 3
     */
    protected string $currency;

    /**
     * A description to be shown on the Skrill payment page in the logo area if there is no logo_url parameter.
     * If no value is submitted and there is no logo, the pay_to_email value is shown as the recipient of the payment.
     *
     * @required false
     * @max-length 30
     */
    protected ?string $recipient_description = null;

    /**
     * Your unique reference or identification number for the transaction.
     * Must be unique for each payment.
     *
     * @required false
     * @max-length 100
     */
    protected ?string $transaction_id = null;

    /**
     * URL to which the customer is returned once the payment is made.
     * If this field is not filled, the Skrill Quick Checkout page closes automatically at the end of the transaction
     * and the customer is returned to the page on your website from where they were redirected to Skrill.
     * A secure return URL option is available.
     *
     * @required false
     * @max-length 240
     */
    protected ?string $return_url = null;

    /**
     * The text on the button when the customer finishes their payment.
     *
     * @required false
     * @max-length 35
     */
    protected ?string $return_url_text = null;

    /**
     * Specifies a target in which the return_url value is displayed upon successful payment from the customer.
     *
     * @required false
     * @default 1
     * @max-length 1
     */
    protected ?int $return_url_target = self::URL_TARGET_TOP;

    /**
     * URL to which the customer is returned if the payment is cancelled or fails.
     * If no cancel URL is provided then the Cancel button is not displayed.
     *
     * @required false
     * @max-length 240
     */
    protected ?string $cancel_url = null;

    /**
     * Specifies a target in which the cancel_url value is displayed upon cancellation of payment by the customer.
     *
     * @required false
     * @default 1
     * @max-length 1
     */
    protected ?int $cancel_url_target = self::URL_TARGET_TOP;

    /**
     * URL to which the transaction details are posted after the payment process is complete.
     * Alternatively, you may specify an email address where the results are sent.
     * If the status_url is omitted, no transaction details are sent.
     *
     * @required false
     * @max-length 400
     */
    protected ?string $status_url = null;

    /**
     * Second URL to which the transaction details are posted after the payment process is complete.
     * Alternatively, you may specify an email address where the results are sent.
     *
     * @required false
     * @max-length 400
     */
    protected ?string $status_url2 = null;

    /**
     * 2 ‐ letter code of the language used for Skrill’s pages.
     *
     * @required false
     * @default EN
     * @max-length 2
     */
    protected ?string $language = 'EN';

    /**
     * Identification of the shop which is the originator of the request. This is most likely used by the payment
     * service providers who act as a proxy for other payment methods as well.
     *
     * @required false
     * @max-length 16
     */
    protected ?string $psp_id = null;

    /**
     * Identification of the shop which is the originator of the request. This is most likely used by the payment
     * service providers who act as a proxy for other payment methods as well.
     *
     * @required false
     * @max-length 120
     */
    protected ?string $submerchant_id = null;

    /**
     * The merchant name listed on the website for which the payment is made.
     *
     * @required false
     * @max-length 240
     */
    protected ?string $submerchant_name = null;

    /**
     * URL of the website for which the payment is made.
     *
     * @required false
     * @max-length 240
     */
    protected ?string $submerchant_url = null;

    /**
     * The URL of the logo which you would like to appear in the top right of the Skrill page.
     * The logo must be accessible via HTTPS or it will not be shown. The logo will be resized to fit.
     * To avoid scaling distortion, the minimum size should be as follows:
     * - If the logo width > height ‐ at least 107px width.
     * - If logo width > height ‐ at least 65px height.
     * Avoid large images (much greater than 256 by 256px) to minimise the page loading time.
     *
     * @required false
     * @max-length 240
     */
    protected ?string $logo_url = null;

    /**
     * Forces only the SID to be returned without the actual page.
     * Useful when using the secure method to redirect the customer to Quick Checkout.
     * 0 => default
     * 1 => prepare only
     *
     * @required false
     * @default 0
     * @max-length 1
     */
    protected ?int $prepare_only = 0;

    /**
     * When a customer pays through Skrill, Skrill submits a preconfigured descriptor with the transaction,
     * containing your business trading name/ brand name.
     * The descriptor is typically displayed on the bank or credit card statement of the customer.
     * For Sofortuberweisung and Direct Debit payment methods, you can submit a dynamic_descriptor,
     * which will override the default value stored by Skrill.
     *
     * @required false
     */
    protected ?string $dynamic_descriptor = null;

    /**
     * This is an optional parameter containing the Session ID returned by the prepare_only call.
     * If you use this parameter then you should not supply any other parameters.
     *
     * @required false
     * @max-length 32
     */
    protected ?string $sid = null;

    /**
     * You can pass a unique referral ID or email of an affiliate from which the customer is referred.
     * The rid value must be included within the actual payment request.
     *
     * @required false
     * @max-length 100
     */
    protected ?string $rid = null;

    /**
     * You can pass additional identifier in this field in order to track your affiliates.
     * You must inform your account manager about the exact value that will be submitted
     * so that affiliates can be tracked.
     *
     * @required false
     * @max-length 100
     */
    protected ?string $ext_ref_id = null;

    /**
     * A comma ‐ separated list of field names that are passed back to your web server when the payment is confirmed.
     * Maximum 5 fields
     *
     * @required false
     * @max-length 240
     */
    protected ?string $merchant_fields = null;

    /**
     * Email address of the customer who is making the payment.
     * If provided, this field is hidden on the payment form.
     * If left empty, the customer has to enter their email address.
     *
     * @required false
     * @max-length 100
     */
    protected ?string $pay_from_email = null;

    /**
     * Customer's first name
     *
     * @required false
     * @max-length 20
     */
    protected ?string $firstname = null;

    /**
     * Customer's last name
     *
     * @required false
     * @max-length 50
     */
    protected ?string $lastname = null;

    /**
     * Date of birth of the customer. The format is ddmmyyyy .
     * Only numeric values are accepted. If provided this field will be pre ‐ filled in the Payment form.
     * This saves time for ELV payments and Skrill Wallet sign ‐ up which require the customer to enter a date of birth.
     *
     * @required false
     * @max-length 8
     * @example 01121980
     */
    protected ?string $date_of_birth = null;

    /**
     * Customer's address (i.e. street).
     *
     * @required false
     * @max-length 100
     */
    protected ?string $address = null;

    /**
     * Customer's address (i.e. town).
     *
     * @required false
     * @max-length 100
     */
    protected ?string $address2 = null;

    /**
     * Customer’s phone number. Only numeric values are accepted.
     *
     * @required false
     * @max-length 20
     */
    protected ?string $phone_number = null;

    /**
     * Customer's postal code/ZIP Code. Only alphanumeric values are accepted.
     *
     * @required false
     * @max-length 9
     */
    protected ?string $postal_code = null;

    /**
     * Customer's city or postal area
     *
     * @required false
     * @max-length 50
     */
    protected ?string $city = null;

    /**
     * Customer's state or region
     *
     * @required false
     * @max-length 50
     */
    protected ?string $state = null;

    /**
     * Customer’s country in the 3‐digit ISO Code
     *
     * @required false
     * @max-length 3
     */
    protected ?string $country = null;

    /**
     * Neteller customer account email or account ID
     *
     * @required false
     * @max-length 150
     */
    protected ?string $neteller_account = null;

    /**
     * Secure ID or Google Authenticator One Time Password for the customer’s Neteller account
     *
     * @required false
     */
    protected ?string $neteller_secure_id = null;

    /**
     * You can include a calculation for the total amount payable, which is displayed in the More information section
     * in the header of the Skrill payment form. Note that Skrill does not check the validity of this data.
     *
     * @required false
     * @max-length 240
     */
    protected ?string $amount2_description = null;

    /**
     * This amount in the currency defined in the field 'currency' will be shown next to amount2_description.
     *
     * @required false
     * @max-length 19
     */
    protected null|int|float $amount2 = null;

    /**
     * @required false
     * @max-length 240
     * @see amount2_description
     */
    protected ?string $amount3_description = null;

    /**
     * @required false
     * @max-length 19
     * @see amount2
     */
    protected null|int|float $amount3 = null;

    /**
     * @required false
     * @max-length 240
     * @see amount2_description
     */
    protected ?string $amount4_description = null;

    /**
     * @required false
     * @max-length 19
     * @see amount2
     */
    protected null|int|float $amount4 = null;

    /**
     * You can show up to five additional details about the product in the More information section
     * in the header of Quick Checkout.
     *
     * @required false
     * @max-length 240
     */
    protected ?string $detail1_description = null;

    /**
     * The detail1_text is shown next to the detail1_description in the More Information section
     * in the header of the payment form with the other payment details.
     * The detail1_description combined with the detail1_text is shown in the more information field
     * of the merchant account history CSV file. Using the example values, this would be Product ID: 4509334.
     * Note if a customer pays for a purchase using Skrill Wallet then this information will also appear
     * in the same field in their account history.
     *
     * @required false
     * @max-length 240
     */
    protected ?string $detail1_text = null;

    /**
     * @required false
     * @max-length 240
     * @see detail1_description
     */
    protected ?string $detail2_description = null;

    /**
     * @required false
     * @max-length 240
     * @see detail1_text
     */
    protected ?string $detail2_text = null;

    /**
     * @required false
     * @max-length 240
     * @see detail1_description
     */
    protected ?string $detail3_description = null;

    /**
     * @required false
     * @max-length 240
     * @see detail1_text
     */
    protected ?string $detail3_text = null;

    /**
     * @required false
     * @max-length 240
     * @see detail1_description
     */
    protected ?string $detail4_description = null;

    /**
     * @required false
     * @max-length 240
     * @see detail1_text
     */
    protected ?string $detail4_text = null;

    /**
     * @required false
     * @max-length 240
     * @see detail1_description
     */
    protected ?string $detail5_description = null;

    /**
     * @required false
     * @max-length 240
     * @see detail1_text
     */
    protected ?string $detail5_text = null;

    public function getPayToEmail(): string
    {
        return $this->pay_to_email;
    }

    public function getAmount(): float|int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getRecipientDescription(): ?string
    {
        return $this->recipient_description;
    }

    public function getTransactionId(): ?string
    {
        return $this->transaction_id;
    }

    public function getReturnUrl(): ?string
    {
        return $this->return_url;
    }

    public function getReturnUrlText(): ?string
    {
        return $this->return_url_text;
    }

    public function getReturnUrlTarget(): ?int
    {
        return $this->return_url_target;
    }

    public function getCancelUrl(): ?string
    {
        return $this->cancel_url;
    }

    public function getCancelUrlTarget(): ?int
    {
        return $this->cancel_url_target;
    }

    public function getStatusUrl(): ?string
    {
        return $this->status_url;
    }

    public function getStatusUrl2(): ?string
    {
        return $this->status_url2;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getPspId(): ?string
    {
        return $this->psp_id;
    }

    public function getSubmerchantId(): ?string
    {
        return $this->submerchant_id;
    }

    public function getSubmerchantName(): ?string
    {
        return $this->submerchant_name;
    }

    public function getSubmerchantUrl(): ?string
    {
        return $this->submerchant_url;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logo_url;
    }

    public function getPrepareOnly(): ?int
    {
        return $this->prepare_only;
    }

    public function getDynamicDescriptor(): ?string
    {
        return $this->dynamic_descriptor;
    }

    public function getSid(): ?string
    {
        return $this->sid;
    }

    public function getRid(): ?string
    {
        return $this->rid;
    }

    public function getExtRefId(): ?string
    {
        return $this->ext_ref_id;
    }

    public function getMerchantFields(): ?string
    {
        return $this->merchant_fields;
    }

    public function getPayFromEmail(): ?string
    {
        return $this->pay_from_email;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->date_of_birth;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getNetellerAccount(): ?string
    {
        return $this->neteller_account;
    }

    public function getNetellerSecureId(): ?string
    {
        return $this->neteller_secure_id;
    }

    public function getAmount2Description(): ?string
    {
        return $this->amount2_description;
    }

    public function getAmount2(): float|int|null
    {
        return $this->amount2;
    }

    public function getAmount3Description(): ?string
    {
        return $this->amount3_description;
    }

    public function getAmount3(): float|int|null
    {
        return $this->amount3;
    }

    public function getAmount4Description(): ?string
    {
        return $this->amount4_description;
    }

    public function getAmount4(): float|int|null
    {
        return $this->amount4;
    }

    public function getDetail1Description(): ?string
    {
        return $this->detail1_description;
    }

    public function getDetail1Text(): ?string
    {
        return $this->detail1_text;
    }

    public function getDetail2Description(): ?string
    {
        return $this->detail2_description;
    }

    public function getDetail2Text(): ?string
    {
        return $this->detail2_text;
    }

    public function getDetail3Description(): ?string
    {
        return $this->detail3_description;
    }

    public function getDetail3Text(): ?string
    {
        return $this->detail3_text;
    }

    public function getDetail4Description(): ?string
    {
        return $this->detail4_description;
    }

    public function getDetail4Text(): ?string
    {
        return $this->detail4_text;
    }

    public function getDetail5Description(): ?string
    {
        return $this->detail5_description;
    }

    public function getDetail5Text(): ?string
    {
        return $this->detail5_text;
    }

    public function setPayToEmail(string $pay_to_email): self
    {
        $this->pay_to_email = $pay_to_email;

        return $this;
    }

    public function setAmount(float|int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setRecipientDescription(?string $recipient_description): self
    {
        $this->recipient_description = $recipient_description;

        return $this;
    }

    public function setTransactionId(?string $transaction_id): self
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }

    public function setReturnUrl(?string $return_url): self
    {
        $this->return_url = $return_url;

        return $this;
    }

    public function setReturnUrlText(?string $return_url_text): self
    {
        $this->return_url_text = $return_url_text;

        return $this;
    }

    public function setReturnUrlTarget(?int $return_url_target): self
    {
        $this->return_url_target = $return_url_target;

        return $this;
    }

    public function setCancelUrl(?string $cancel_url): self
    {
        $this->cancel_url = $cancel_url;

        return $this;
    }

    public function setCancelUrlTarget(?int $cancel_url_target): self
    {
        $this->cancel_url_target = $cancel_url_target;

        return $this;
    }

    public function setStatusUrl(?string $status_url): self
    {
        $this->status_url = $status_url;

        return $this;
    }

    public function setStatusUrl2(?string $status_url2): self
    {
        $this->status_url2 = $status_url2;

        return $this;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function setPspId(?string $psp_id): self
    {
        $this->psp_id = $psp_id;

        return $this;
    }

    public function setSubmerchantId(?string $submerchant_id): self
    {
        $this->submerchant_id = $submerchant_id;

        return $this;
    }

    public function setSubmerchantName(?string $submerchant_name): self
    {
        $this->submerchant_name = $submerchant_name;

        return $this;
    }

    public function setSubmerchantUrl(?string $submerchant_url): self
    {
        $this->submerchant_url = $submerchant_url;

        return $this;
    }

    public function setLogoUrl(?string $logo_url): self
    {
        $this->logo_url = $logo_url;

        return $this;
    }

    public function setPrepareOnly(?int $prepare_only): self
    {
        $this->prepare_only = $prepare_only;

        return $this;
    }

    public function setDynamicDescriptor(?string $dynamic_descriptor): self
    {
        $this->dynamic_descriptor = $dynamic_descriptor;

        return $this;
    }

    public function setSid(?string $sid): self
    {
        $this->sid = $sid;

        return $this;
    }

    public function setRid(?string $rid): self
    {
        $this->rid = $rid;

        return $this;
    }

    public function setExtRefId(?string $ext_ref_id): self
    {
        $this->ext_ref_id = $ext_ref_id;

        return $this;
    }

    public function setMerchantFields(?string $merchant_fields): self
    {
        $this->merchant_fields = $merchant_fields;

        return $this;
    }

    public function setPayFromEmail(?string $pay_from_email): self
    {
        $this->pay_from_email = $pay_from_email;

        return $this;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function setDateOfBirth(?string $date_of_birth): self
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function setPostalCode(?string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function setNetellerAccount(?string $neteller_account): self
    {
        $this->neteller_account = $neteller_account;

        return $this;
    }

    public function setNetellerSecureId(?string $neteller_secure_id): self
    {
        $this->neteller_secure_id = $neteller_secure_id;

        return $this;
    }

    public function setAmount2Description(?string $amount2_description): self
    {
        $this->amount2_description = $amount2_description;

        return $this;
    }

    public function setAmount2(float|int|null $amount2): self
    {
        $this->amount2 = $amount2;

        return $this;
    }

    public function setAmount3Description(?string $amount3_description): self
    {
        $this->amount3_description = $amount3_description;

        return $this;
    }

    public function setAmount3(float|int|null $amount3): self
    {
        $this->amount3 = $amount3;

        return $this;
    }

    public function setAmount4Description(?string $amount4_description): self
    {
        $this->amount4_description = $amount4_description;

        return $this;
    }

    public function setAmount4(float|int|null $amount4): self
    {
        $this->amount4 = $amount4;

        return $this;
    }

    public function setDetail1Description(?string $detail1_description): self
    {
        $this->detail1_description = $detail1_description;

        return $this;
    }

    public function setDetail1Text(?string $detail1_text): self
    {
        $this->detail1_text = $detail1_text;

        return $this;
    }

    public function setDetail2Description(?string $detail2_description): self
    {
        $this->detail2_description = $detail2_description;

        return $this;
    }

    public function setDetail2Text(?string $detail2_text): self
    {
        $this->detail2_text = $detail2_text;

        return $this;
    }

    public function setDetail3Description(?string $detail3_description): self
    {
        $this->detail3_description = $detail3_description;

        return $this;
    }

    public function setDetail3Text(?string $detail3_text): self
    {
        $this->detail3_text = $detail3_text;

        return $this;
    }

    public function setDetail4Description(?string $detail4_description): self
    {
        $this->detail4_description = $detail4_description;

        return $this;
    }

    public function setDetail4Text(?string $detail4_text): self
    {
        $this->detail4_text = $detail4_text;

        return $this;
    }

    public function setDetail5Description(?string $detail5_description): self
    {
        $this->detail5_description = $detail5_description;

        return $this;
    }

    public function setDetail5Text(?string $detail5_text): self
    {
        $this->detail5_text = $detail5_text;

        return $this;
    }
}