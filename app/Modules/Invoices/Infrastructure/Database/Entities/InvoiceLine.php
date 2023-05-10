<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Entities;

use Carbon\Carbon;
use Database\Factories\Invoice\InvoiceLineFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\UuidInterface;
use Support\DAO\Contracts\HasUuidTrait;

/**
 * @mixin Builder
 *
 * @method static Builder|static query()
 * @method static static make(array $attributes = [])
 * @method static static create(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method InvoiceLine firstOrNew(array $attributes = [], array $values = [])
 * @method InvoiceLine firstOrFail(array $columns = ['*'])
 * @method InvoiceLine firstOrCreate(array $attributes, array $values = [])
 * @method InvoiceLine firstOr(array $columns = ['*'], \Closure $callback = null)
 * @method InvoiceLine firstWhere(array $column, string|null $operator = null, string|null $value = null, string|null $boolean = 'and')
 * @method InvoiceLine updateOrCreate(array $attributes, array $values = [])
 * @method null|static first(array $columns = ['*'])
 * @method static static findOrFail(string $id, array $columns = ['*'])
 * @method static static findOrNew(string $id, array $columns = ['*'])
 * @method static null|static find(string $id, array $columns = ['*'])
 * @method static Builder byInvoiceId(UuidInterface|string $invoiceId)
 *
 * @property string $id
 * @property string $invoice_id
 * @property string $product_id
 * @property int $quantity
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Invoice $invoice
 * @property-read Product $product
 */
final class InvoiceLine extends Eloquent
{
    use HasTimestamps;
    use HasUuidTrait;
    use HasFactory;

    protected $table = 'invoice_product_lines';

    protected $keyType = 'string';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    protected static function newFactory(): InvoiceLineFactory
    {
        return InvoiceLineFactory::new();
    }

    /************************************************
     *                 RELATIONSHIPS                *
     ************************************************/

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /************************************************
     *                    SCOPES                    *
     ************************************************/

    public function scopeByInvoiceId(Builder $query, UuidInterface|string $invoiceId): Builder
    {
        return $query->where('invoice_id', '=', (string) $invoiceId);
    }
}
