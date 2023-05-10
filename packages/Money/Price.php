<?php

declare(strict_types=1);

namespace Money;

use RuntimeException;

final class Price
{
    public function __construct(
        public int      $cents,
        public Currency $currency,
    ) {
    }

    public static function zero(Currency $currency): Price
    {
        return self::build(0, $currency);
    }

    public static function build(int $cents, Currency $currency): Price
    {
        return new self(
            cents: $cents,
            currency: $currency,
        );
    }

    public function add(Price $price): Price
    {
        if (false === $this->hasCurrency($price->currency)) {
            throw new RuntimeException(sprintf(
                'Cannot add price with different currency %s',
                $price->currency->symbol,
            ));
        }

        return self::build(
            cents: $this->cents + $price->cents,
            currency: $this->currency,
        );
    }

    public function multiply(int $times): Price
    {
        if ($times < 0) {
            throw new RuntimeException(sprintf(
                'Cannot multiple price with times %d',
                $times,
            ));
        }

        return self::build(
            cents: $this->cents * $times,
            currency: $this->currency,
        );
    }

    public function hasCurrency(Currency $currency): bool
    {
        return $this->currency->symbol === $currency->symbol;
    }

    public function toString(): string
    {
        return '$' . number_format(
            round($this->cents / 10 ** $this->currency->roundPrecision(), $this->currency->roundPrecision()),
            $this->currency->roundPrecision(),
        );
    }
}
