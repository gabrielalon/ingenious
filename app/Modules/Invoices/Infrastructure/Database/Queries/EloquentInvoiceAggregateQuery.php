<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Queries;

use App\Modules\Invoices\Application\Queries\InvoiceAggregateQueryInterface;
use App\Modules\Invoices\Application\Queries\InvoiceLineQueryInterface;
use App\Modules\Invoices\Application\Queries\InvoiceQueryInterface;
use App\Modules\Invoices\Application\ReadModels\InvoiceAggregateDto;
use Ramsey\Uuid\UuidInterface;

final class EloquentInvoiceAggregateQuery implements InvoiceAggregateQueryInterface
{
    public function __construct(
        private InvoiceQueryInterface $invoiceQuery,
        private InvoiceLineQueryInterface $invoiceLineQuery,
    ) {
    }

    public function fetchOne(UuidInterface $id): InvoiceAggregateDto
    {
        return new InvoiceAggregateDto(
            invoice: $this->invoiceQuery->fetchOne($id),
            invoiceLines: $this->invoiceLineQuery->fetchAllByInvoiceId($id),
        );
    }
}
