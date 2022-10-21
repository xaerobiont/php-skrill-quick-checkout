<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

interface StatusResponseInterface
{
    public function getPayToEmail(): string;

    public function getPayFromEmail(): string;

    public function getMerchantId(): mixed;

    public function getTransactionId(): mixed;

    public function getMbTransactionId(): mixed;

    public function getMbAmount(): int|float;

    public function getMbCurrency(): string;

    public function getStatus(): int;

    public function getMd5sig(): string;

    public function getAmount(): int|float;

    public function getCurrency(): string;

    public function verifySignature(string $secretWord): bool;
}