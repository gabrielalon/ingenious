<?php declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Infrastructure\Queries;

use App\Infrastructure\Exceptions\NotFoundException;
use App\Modules\Invoices\Application\Queries\InvoiceAggregateQueryInterface;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use Illuminate\Support\Str;
use Tests\TestCase;

class EloquentInvoiceAggregateQueryTest extends TestCase
{
    private InvoiceAggregateQueryInterface $query;

    protected function setUp(): void
    {
        parent::setUp();

        $this->query = resolve(InvoiceAggregateQueryInterface::class);
    }

    /** @test */
    public function shouldFailToFetchInvoiceAggregate(): void
    {
        $invoiceId = Str::uuid();

        $this->expectExceptionObject(new NotFoundException(sprintf(
            'Invoice not found for given id %s.',
            $invoiceId->toString(),
        )));

        $this->query->fetchOne($invoiceId);
    }

    /** @test */
    public function shouldFetchInvoiceAggregate(): void
    {
        Invoice::factory()->create([
            'id' => $invoiceId = Str::uuid(),
            'number' => $number = $this->faker->uuid(),
            'date' => $date = $this->faker->date(),
            'due_date' => $dueDate = $this->faker->date(),
        ]);

        $dto = $this->query->fetchOne($invoiceId);

        $this->assertEquals($number, $dto->invoice->number);
        $this->assertEquals($date, $dto->invoice->date->toDateString());
        $this->assertEquals($dueDate, $dto->invoice->dueDate->toDateString());
        $this->assertCount(0, $dto->invoiceLines);
        $this->assertEquals(0, $dto->totalPrice()->cents);
    }
}
