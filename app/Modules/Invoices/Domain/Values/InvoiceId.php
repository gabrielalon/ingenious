<?php declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Values;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class InvoiceId
{
    public function __construct(
        public UuidInterface $value,
    ) {
    }

    public static function fromId(string $id): InvoiceId
    {
        return new self(Uuid::fromString($id));
    }
}
