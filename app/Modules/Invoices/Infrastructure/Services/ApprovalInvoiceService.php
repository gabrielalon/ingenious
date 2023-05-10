<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Services;

use App\Infrastructure\Exceptions\UpdateResourceFailedException;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Application\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Application\Services\InvoiceServiceInterface;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice as InvoiceEntity;
use Ramsey\Uuid\UuidInterface;

final class ApprovalInvoiceService implements InvoiceServiceInterface
{
    public function __construct(
        private ApprovalFacadeInterface $approvalFacade,
        private InvoiceRepositoryInterface $invoiceRepository,
    ) {
    }

    public function approve(UuidInterface $invoiceId): void
    {
        $invoice = $this->invoiceRepository->fetchOne($invoiceId);

        try {
            $this->approvalFacade->approve(new ApprovalDto(
                id: $invoice->invoiceId->value,
                status: $invoice->invoiceStatus->value,
                entity: InvoiceEntity::class,
            ));
        } catch (\LogicException $exception) {
            throw new UpdateResourceFailedException($exception->getMessage());
        }
    }

    public function reject(UuidInterface $invoiceId): void
    {
        $invoice = $this->invoiceRepository->fetchOne($invoiceId);

        try {
            $this->approvalFacade->reject(new ApprovalDto(
                id: $invoice->invoiceId->value,
                status: $invoice->invoiceStatus->value,
                entity: InvoiceEntity::class,
            ));
        } catch (\LogicException $exception) {
            throw new UpdateResourceFailedException($exception->getMessage());
        }
    }
}
