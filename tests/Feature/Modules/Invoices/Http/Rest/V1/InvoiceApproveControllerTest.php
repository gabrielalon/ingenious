<?php declare(strict_types=1);

namespace Tests\Feature\Modules\Invoices\Http\Rest\V1;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class InvoiceApproveControllerTest extends TestCase
{
    /** @test */
    public function shouldFailToApproveInvoice(): void
    {
        $invoiceId = Str::uuid();

        $this->putJson(route('api.v1.invoice.approve', $invoiceId->toString()))->assertNotFound();
    }

    /** @test */
    public function shouldFailToAlreadyApprovedInvoice(): void
    {
        Invoice::factory()->create(['id' => $invoiceId = Str::uuid(), 'status' => StatusEnum::APPROVED->value]);

        $this->putJson(route('api.v1.invoice.approve', $invoiceId->toString()))->assertStatus(Response::HTTP_EXPECTATION_FAILED);
    }

    /** @test */
    public function shouldApproveInvoice(): void
    {
        Invoice::factory()->create(['id' => $invoiceId = Str::uuid(), 'status' => StatusEnum::DRAFT->value]);

        $this->putJson(route('api.v1.invoice.approve', $invoiceId->toString()))->assertNoContent();

        $this->assertDatabaseHas('invoices', [
            'id' => $invoiceId->toString(),
            'status' => StatusEnum::APPROVED->value,
        ]);
    }
}
