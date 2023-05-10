<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\ReadModels;

use Money\Currency;
use Money\Price;

final readonly class InvoiceAggregateDto
{
    /**
     * @param InvoiceLineDto[] $invoiceLines
     */
    public function __construct(
        public InvoiceDto $invoice,
        public array $invoiceLines,
    ) {

    }

    public function totalPrice(): Price
    {
        $totalPrice = Price::zero(Currency::USD());

        foreach ($this->invoiceLines as $invoiceLine) {
            $totalPrice = $totalPrice->add($invoiceLine->totalPrice());
        }

        return $totalPrice;
    }
}
