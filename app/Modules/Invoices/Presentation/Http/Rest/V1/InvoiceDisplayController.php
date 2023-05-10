<?php declare(strict_types=1);

namespace App\Modules\Invoices\Presentation\Http\Rest\V1;

use App\Modules\Invoices\Application\Queries\InvoiceAggregateQueryInterface;
use App\Modules\Invoices\Presentation\Http\Rest\V1\Responses\InvoiceResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

final readonly class InvoiceDisplayController
{
    public function __construct(
        private InvoiceAggregateQueryInterface $invoiceAggregateQuery,
    ) {
    }

    public function __invoke(Request $request, string $invoiceId): InvoiceResponse
    {
        return InvoiceResponse::make(
            dto: $this->invoiceAggregateQuery->fetchOne(Uuid::fromString($invoiceId)),
        );
    }
}
