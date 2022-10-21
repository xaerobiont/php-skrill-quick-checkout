<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

class PaymentProcessor
{
    function __construct(
        protected QuickCheckoutInterface $checkout,
        protected string $gatewayUrl = 'https://pay.skrill.com',
    )
    {
    }

    /**
     * @throws SkrillException
     */
    public function getPaymentUrl(): string
    {
        $sid = $this->receiveSID();

        return sprintf('%s/app/?sid=%s', $this->gatewayUrl, $sid);
    }

    /**
     * @throws SkrillException
     */
    protected function receiveSID(): string
    {
        $postData = $this->checkout->toArray(true);
        # Force set prepare_only to 1
        $postData['prepare_only'] = 1;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->gatewayUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        $response = (string)curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if (!str_starts_with((string)$code, '20')) {
            throw new SkrillException(sprintf(
                'Could not send request to Skrill payment api. Response: %s with code %s',
                $response, $code
            ));
        }

        return $response;
    }
}