<?php declare(strict_types=1);

namespace Tests\Feature\Modules\Invoices\Http\Rest\V1;

use App\Modules\Invoices\Infrastructure\Database\Entities\Invoice;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceLine;
use Illuminate\Support\Str;
use Tests\TestCase;

class InvoiceDisplayControllerTest extends TestCase
{
    /** @test */
    public function shouldFailToDisplayInvoice(): void
    {
        $invoiceId = Str::uuid();

        $this->getJson(route('api.v1.invoice.display', $invoiceId->toString()))->assertNotFound();
    }

    /** @test */
    public function shouldDisplayInvoice(): void
    {
        Invoice::factory()->create(['id' => $invoiceId = Str::uuid()]);
        InvoiceLine::factory()->count(3)->create(['invoice_id' => $invoiceId]);

        $response = $this->getJson(route('api.v1.invoice.display', $invoiceId->toString()))->assertOK();

        $response->assertJsonStructure(['invoice' => [
            'number',
            'date',
            'due_date',
            'company' => [
                'name',
                'street',
                'city',
                'zip_code',
                'phone',
            ],
            'billed_company' => [
                'name',
                'street',
                'city',
                'zip_code',
                'phone',
                'email',
            ],
            'products' => ['*' => [
                'name',
                'quantity',
                'unit_price',
                'total_price',
            ]],
            'total_price',
        ]]);
    }
}
