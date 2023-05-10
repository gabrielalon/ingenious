<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Queries;

use App\Infrastructure\Exceptions\NotFoundException;
use App\Modules\Invoices\Application\Queries\InvoiceQueryInterface;
use App\Modules\Invoices\Application\ReadModels\CompanyDto;
use App\Modules\Invoices\Application\ReadModels\InvoiceDto;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use Ramsey\Uuid\UuidInterface;

final class EloquentInvoiceQuery implements InvoiceQueryInterface
{
    /**
     * @throws NotFoundException
     */
    public function fetchOne(UuidInterface $id): InvoiceDto
    {
        $invoice = Invoice::query()->find($id->toString());

        if ($invoice === null) {
            throw new NotFoundException(sprintf(
                'Invoice not found for given id %s.',
                $id->toString(),
            ));
        }

        return new InvoiceDto(
            number: $invoice->number,
            date: $invoice->date,
            dueDate: $invoice->due_date,
            company: new CompanyDto(
                name: $invoice->company->name,
                street: $invoice->company->street,
                city: $invoice->company->city,
                zipCode: $invoice->company->zip,
                phone: $invoice->company->phone,
                email: $invoice->company->email,
            ),
            billedCompany: new CompanyDto(
                name: $invoice->company->name,
                street: $invoice->company->street,
                city: $invoice->company->city,
                zipCode: $invoice->company->zip,
                phone: $invoice->company->phone,
                email: $invoice->company->email,
            ),
        );
    }
}
