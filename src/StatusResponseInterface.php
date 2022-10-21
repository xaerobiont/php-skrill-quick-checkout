<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

interface StatusResponseInterface
{
    public function getPayToEmail(): string;

    public function getPayFromEmail(): string;

    public function getMerchantId(): mixed;

    public function getTransactionId(): mixed;

    public function getMbAmount(): mixed;

    public function getMbCurrency(): string;

    public function getStatus(): mixed;

    public function getMd5sig(): string;

    public function verifySignature(string $secretWord): bool;
}