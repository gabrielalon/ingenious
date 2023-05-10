<?php declare(strict_types=1);

namespace App\Modules\Invoices\Presentation\Http\Rest\V1;

use App\Modules\Invoices\Application\Services\InvoiceServiceInterface;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

final readonly class InvoiceApproveController
{
    public function __construct(
        private InvoiceServiceInterface $invoiceService,
    ) {
    }

    public function __invoke(Request $request, string $invoiceId): Response
    {
        $this->invoiceService->approve(Uuid::fromString($invoiceId));

        return response()->noContent();
    }
}
