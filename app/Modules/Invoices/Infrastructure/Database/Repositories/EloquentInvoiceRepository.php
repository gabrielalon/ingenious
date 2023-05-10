<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Repositories;

use App\Infrastructure\Exceptions\NotFoundException;
use App\Modules\Invoices\Application\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Values;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice as InvoiceEntity;
use Ramsey\Uuid\UuidInterface;

final class EloquentInvoiceRepository implements InvoiceRepositoryInterface
{
    public function fetchOne(UuidInterface $id): Invoice
    {
        $invoice = InvoiceEntity::query()->find($id->toString());

        if ($invoice === null) {
            throw new NotFoundException(sprintf(
                'Invoice not found for given id %s.',
                $id->toString(),
            ));
        }

        return new Invoice(
            invoiceId: Values\InvoiceId::fromId($invoice->id),
            invoiceStatus: Values\InvoiceStatus::fromStatus($invoice->status),
        );
    }

    public function changeStatus(Values\InvoiceId $invoiceId, Values\InvoiceStatus $invoiceStatus): void
    {
        InvoiceEntity::byUuid($invoiceId->value)->update(['status' => $invoiceStatus->value->value]);
    }
}
