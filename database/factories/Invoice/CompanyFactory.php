<?php declare(strict_types=1);

namespace Database\Factories\Invoice;

use App\Modules\Invoices\Infrastructure\Database\Entities\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

final class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->company(),
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
