<?php declare(strict_types=1);

namespace App\Modules\Invoices\Application\Repositories;

use App\Modules\Invoices\Domain\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepositoryInterface
{
    public function fetchOne(UuidInterface $id): Invoice;

    public function save(Invoice $invoice): void;
}
