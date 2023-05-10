<?php declare(strict_types=1);

namespace Database\Factories\Invoice;

use App\Modules\Invoices\Infrastructure\Database\Entities\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Money\Currency;

final class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->name,
            'price' => random_int(1111, 9999999),
            'currency' => Currency::USD()->symbol,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
