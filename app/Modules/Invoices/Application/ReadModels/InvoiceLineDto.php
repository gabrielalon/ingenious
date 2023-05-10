<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\ReadModels;

use Money\Price;

final readonly class InvoiceLineDto
{
    public function __construct(
        public string $name,
        public int $quantity,
        public Price $unitPrice,
    ) {
    }

    public function totalPrice(): Price
    {
        return $this->unitPrice->multiply($this->quantity);
    }
}
