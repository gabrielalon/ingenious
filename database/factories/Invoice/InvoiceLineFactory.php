<?php declare(strict_types=1);

namespace Database\Factories\Invoice;

use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceLine;
use App\Modules\Invoices\Infrastructure\Database\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

final class InvoiceLineFactory extends Factory
{
    protected $model = InvoiceLine::class;

    public function definition(): array
    {
        Product::factory()->create(['id' => $productId = $this->faker->uuid]);

        return [
            'id' => $this->faker->uuid,
            'product_id' => $productId,
            'quantity' => random_int(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
