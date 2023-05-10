<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\Queries;

use App\Modules\Invoices\Application\ReadModels\InvoiceLineDto;
use Ramsey\Uuid\UuidInterface;

interface InvoiceLineQueryInterface
{
    /** @return InvoiceLineDto[] */
    public function fetchAllByInvoiceId(UuidInterface $invoiceId): array;
}
