<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Application\Queries\InvoiceAggregateQueryInterface;
use App\Modules\Invoices\Application\Queries\InvoiceLineQueryInterface;
use App\Modules\Invoices\Application\Queries\InvoiceQueryInterface;
use App\Modules\Invoices\Application\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Application\Services\InvoiceServiceInterface;
use App\Modules\Invoices\Infrastructure\Services\ApprovalInvoiceService;
use App\Modules\Invoices\Infrastructure\Database\Queries\EloquentInvoiceAggregateQuery;
use App\Modules\Invoices\Infrastructure\Database\Queries\EloquentInvoiceLineQuery;
use App\Modules\Invoices\Infrastructure\Database\Queries\EloquentInvoiceQuery;
use App\Modules\Invoices\Infrastructure\Database\Repositories\EloquentInvoiceRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoiceServiceInterface::class, ApprovalInvoiceService::class);

        $this->app->scoped(InvoiceRepositoryInterface::class, EloquentInvoiceRepository::class);

        $this->app->scoped(InvoiceQueryInterface::class, EloquentInvoiceQuery::class);
        $this->app->scoped(InvoiceLineQueryInterface::class, EloquentInvoiceLineQuery::class);
        $this->app->scoped(InvoiceAggregateQueryInterface::class, EloquentInvoiceAggregateQuery::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoiceServiceInterface::class,

            InvoiceRepositoryInterface::class,

            InvoiceQueryInterface::class,
            InvoiceLineQueryInterface::class,
            InvoiceAggregateQueryInterface::class,
        ];
    }
}
