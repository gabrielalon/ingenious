<?php declare(strict_types=1);

namespace Money;

final class Currency
{
    private int $precision;

    private function __construct(
        public readonly string $symbol,
    ) {
        $this->precision = 2;
    }

    public static function USD(): Currency
    {
        return new Currency('USD');
    }

    public function roundPrecision(): int
    {
        return $this->precision;
    }
}
