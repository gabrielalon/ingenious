<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Queries;

use App\Modules\Invoices\Application\Queries\InvoiceLineQueryInterface;
use App\Modules\Invoices\Application\ReadModels\InvoiceLineDto;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceLine;
use Ramsey\Uuid\UuidInterface;

final class EloquentInvoiceLineQuery implements InvoiceLineQueryInterface
{
    public function fetchAllByInvoiceId(UuidInterface $invoiceId): array
    {
        return InvoiceLine::byInvoiceId($invoiceId)
            ->with('product')
            ->cursor()
            ->map(fn (InvoiceLine $line) => new InvoiceLineDto(
                name: $line->product->name,
                quantity: $line->quantity,
                unitPrice: $line->product->price,
            ))
            ->toArray();
    }
}
