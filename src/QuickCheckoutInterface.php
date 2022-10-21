<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

interface QuickCheckoutInterface
{
    public function toArray(bool $excludeNulls): array;

    public function getPayToEmail(): string;

    public function getAmount(): float|int;

    public function getCurrency(): string;
}