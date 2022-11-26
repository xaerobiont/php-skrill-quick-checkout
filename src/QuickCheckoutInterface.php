<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

interface QuickCheckoutInterface
{
    public function getPayToEmail(): string;

    public function getAmount(): float|int;

    public function getCurrency(): string;

    public function toArray(bool $excludeNulls): array;
}