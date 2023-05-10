<?php declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Infrastructure\Queries;

use App\Infrastructure\Exceptions\NotFoundException;
use App\Modules\Invoices\Application\Queries\InvoiceQueryInterface;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use Illuminate\Support\Str;
use Tests\TestCase;

class EloquentInvoiceQueryTest extends TestCase
{
    private InvoiceQueryInterface $query;

    protected function setUp(): void
    {
        parent::setUp();

        $this->query = resolve(InvoiceQueryInterface::class);
    }

    /** @test */
    public function shouldFailToFetchInvoice(): void
    {
        $invoiceId = Str::uuid();

        $this->expectExceptionObject(new NotFoundException(sprintf(
            'Invoice not found for given id %s.',
            $invoiceId->toString(),
        )));

        $this->query->fetchOne($invoiceId);
    }

    /** @test */
    public function shouldFetchInvoice(): void
    {
        Invoice::factory()->create([
            'id' => $invoiceId = Str::uuid(),
            'number' => $number = $this->faker->uuid(),
            'date' => $date = $this->faker->date(),
            'due_date' => $dueDate = $this->faker->date(),
        ]);

        $dto = $this->query->fetchOne($invoiceId);

        $this->assertEquals($number, $dto->number);
        $this->assertEquals($date, $dto->date->toDateString());
        $this->assertEquals($dueDate, $dto->dueDate->toDateString());
    }
}
