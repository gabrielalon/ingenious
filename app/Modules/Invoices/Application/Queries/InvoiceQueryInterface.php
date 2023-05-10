<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\Queries;

use App\Modules\Invoices\Application\ReadModels\InvoiceDto;
use Ramsey\Uuid\UuidInterface;

interface InvoiceQueryInterface
{
    public function fetchOne(UuidInterface $id): InvoiceDto;
}
