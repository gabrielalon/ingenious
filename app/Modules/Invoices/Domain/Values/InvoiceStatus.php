<?php declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Values;

use App\Domain\Enums\StatusEnum;

final readonly class InvoiceStatus
{
    public function __construct(
        public StatusEnum $value,
    ) {
    }

    public static function fromStatus(string $status): InvoiceStatus
    {
        return new self(StatusEnum::tryFrom($status));
    }
}
