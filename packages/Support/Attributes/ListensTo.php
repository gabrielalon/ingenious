<?php declare(strict_types=1);

namespace Support\Attributes;

use Attribute;

#[Attribute]
class ListensTo
{
    public function __construct(
        public string $eventClass
    ) {
    }
}
