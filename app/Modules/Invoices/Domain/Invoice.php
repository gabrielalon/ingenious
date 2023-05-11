<?php declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

final class Invoice
{
    public function __construct(
        public Values\InvoiceId $invoiceId,
        public Values\InvoiceStatus $invoiceStatus,
    ) {
    }

    public function setInvoiceStatus(Values\InvoiceStatus $invoiceStatus): void
    {
        $this->invoiceStatus = $invoiceStatus;
    }
}
