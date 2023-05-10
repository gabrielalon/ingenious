<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\Queries;

use App\Modules\Invoices\Application\ReadModels\InvoiceAggregateDto;
use Ramsey\Uuid\UuidInterface;

interface InvoiceAggregateQueryInterface
{
    public function fetchOne(UuidInterface $id): InvoiceAggregateDto;
}
