<?php

declare(strict_types=1);

namespace Support;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class IdGenerator
{
    public function id(): string
    {
        return $this->uuid()->toString();
    }

    public function uuid(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
