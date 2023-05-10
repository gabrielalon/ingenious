<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\Services;

use Ramsey\Uuid\UuidInterface;

interface InvoiceServiceInterface
{
    public function approve(UuidInterface $invoiceId): void;

    public function reject(UuidInterface $invoiceId): void;
}
