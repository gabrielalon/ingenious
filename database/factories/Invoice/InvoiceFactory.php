<?php declare(strict_types=1);

namespace Database\Factories\Invoice;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Infrastructure\Database\Entities\Company;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

final class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        Company::factory()->create(['id' => $companyId =  $this->faker->uuid]);

        return [
            'id' => $this->faker->uuid,
            'company_id' => $companyId,
            'number' => $this->faker->uuid(),
            'date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'status' => StatusEnum::cases()[array_rand(StatusEnum::cases())],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
