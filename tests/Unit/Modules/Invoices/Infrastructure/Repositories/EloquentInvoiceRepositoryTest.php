<?php declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Infrastructure\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Infrastructure\Exceptions\NotFoundException;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use App\Modules\Invoices\Infrastructure\Database\Repositories\EloquentInvoiceRepository;
use Illuminate\Support\Str;
use Tests\TestCase;

class EloquentInvoiceRepositoryTest extends TestCase
{
    private EloquentInvoiceRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = resolve(EloquentInvoiceRepository::class);
    }

    /** @test */
    public function shouldFailToFetchInvoice(): void
    {
        $invoiceId = Str::uuid();

        $this->expectExceptionObject(new NotFoundException(sprintf(
            'Invoice not found for given id %s.',
            $invoiceId->toString(),
        )));

        $this->repository->fetchOne($invoiceId);
    }

    /** @test */
    public function shouldFetchInvoice(): void
    {
        Invoice::factory()->create([
            'id' => $invoiceId = Str::uuid(),
            'status' => $status = StatusEnum::REJECTED->value,
        ]);

        $model = $this->repository->fetchOne($invoiceId);

        $this->assertEquals($invoiceId, $model->invoiceId->value);
        $this->assertEquals($status, $model->invoiceStatus->value->value);
    }
}
