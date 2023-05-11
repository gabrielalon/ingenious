<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Subscribers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Application\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\Values\InvoiceStatus;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use Support\Attributes\ListensTo;

final readonly class InvoiceSubscriber
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
    ) {
    }

    #[ListensTo(EntityApproved::class)]
    public function onEntityApproved(EntityApproved $event): void
    {
        $this->changeState($event->approvalDto, StatusEnum::APPROVED);
    }

    #[ListensTo(EntityRejected::class)]
    public function onEntityRejected(EntityRejected $event): void
    {
        $this->changeState($event->approvalDto, StatusEnum::REJECTED);
    }

    private function changeState(ApprovalDto $dto, StatusEnum $status): void
    {
        if ($dto->entity === Invoice::class) {
            $invoice = $this->invoiceRepository->fetchOne($dto->id);
            $invoice->changeInvoiceStatus(InvoiceStatus::fromStatus($status->value));

            $this->invoiceRepository->save($invoice);
        }
    }
}
