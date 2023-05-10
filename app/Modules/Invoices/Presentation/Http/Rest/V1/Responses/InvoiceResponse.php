<?php declare(strict_types=1);

namespace App\Modules\Invoices\Presentation\Http\Rest\V1\Responses;

use App\Modules\Invoices\Application\ReadModels\InvoiceAggregateDto;
use App\Modules\Invoices\Application\ReadModels\InvoiceLineDto;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class InvoiceResponse extends JsonResponse
{
    public static function make(InvoiceAggregateDto $dto): InvoiceResponse
    {
        return new self(
            data: ['invoice' => [
                'number' => $dto->invoice->number,
                'date' => $dto->invoice->date->toDateString(),
                'due_date' => $dto->invoice->dueDate->toDateString(),
                'company' => [
                    'name' => $dto->invoice->company->name,
                    'street' => $dto->invoice->company->street,
                    'city' => $dto->invoice->company->city,
                    'zip_code' => $dto->invoice->company->zipCode,
                    'phone' => $dto->invoice->company->phone,
                ],
                'billed_company' => [
                    'name' => $dto->invoice->company->name,
                    'street' => $dto->invoice->company->street,
                    'city' => $dto->invoice->company->city,
                    'zip_code' => $dto->invoice->company->zipCode,
                    'phone' => $dto->invoice->company->phone,
                    'email' => $dto->invoice->company->email,
                ],
                'products' => array_map(static fn (InvoiceLineDto $lineDto) => [
                    'name' => $lineDto->name,
                    'quantity' => $lineDto->quantity,
                    'unit_price' => $lineDto->unitPrice,
                    'total_price' => $lineDto->totalPrice()->toString(),
                ], $dto->invoiceLines),
                'total_price' => $dto->totalPrice()->toString(),
            ]],
            status: Response::HTTP_OK,
        );
    }
}
