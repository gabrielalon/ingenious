<?php declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Infrastructure\Queries;

use App\Modules\Invoices\Application\Queries\InvoiceLineQueryInterface;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceLine;
use App\Modules\Invoices\Infrastructure\Database\Entities\Product;
use Illuminate\Support\Str;
use Tests\TestCase;

class EloquentInvoiceLineQueryTest extends TestCase
{
    private InvoiceLineQueryInterface $query;

    protected function setUp(): void
    {
        parent::setUp();

        $this->query = resolve(InvoiceLineQueryInterface::class);
    }

    /** @test */
    public function shouldFetchInvoiceLines(): void
    {
        $invoiceId = Str::uuid();
        Invoice::factory()->create(['id' => $invoiceId]);

        Product::factory()->create([
            'id' => $productId = $this->faker->uuid,
            'name' => $name = $this->faker->name,
        ]);
        InvoiceLine::factory()->create([
            'invoice_id' => $invoiceId,
            'product_id' => $productId,
            'quantity' => $quantity = random_int(1, 100),
        ]);

        $collection = $this->query->fetchAllByInvoiceId($invoiceId);

        $this->assertCount(1, $collection);

        foreach ($collection as $dto) {
            $this->assertEquals($quantity, $dto->quantity);
            $this->assertEquals($name, $dto->name);
        }
    }
}
