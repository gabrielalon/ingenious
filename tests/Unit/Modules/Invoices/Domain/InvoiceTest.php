<?php declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Values;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    /** @test */
    public function itShouldCreateModel(): void
    {
        $model = new Invoice(
            invoiceId: $invoiceId = Values\InvoiceId::fromId($this->faker->uuid),
            invoiceStatus: $invoiceStatus = Values\InvoiceStatus::fromStatus(StatusEnum::APPROVED->value),
        );

        $this->assertEquals($invoiceId->value, $model->invoiceId->value);
        $this->assertEquals($invoiceStatus->value, $model->invoiceStatus->value);
    }
}
