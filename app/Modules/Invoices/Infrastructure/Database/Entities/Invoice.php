<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Entities;

use Carbon\Carbon;
use Database\Factories\Invoice\InvoiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Support\DAO\Contracts\HasUuidTrait;

/**
 * @mixin Builder
 *
 * @method static Builder|static query()
 * @method static static make(array $attributes = [])
 * @method static static create(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method Invoice firstOrNew(array $attributes = [], array $values = [])
 * @method Invoice firstOrFail(array $columns = ['*'])
 * @method Invoice firstOrCreate(array $attributes, array $values = [])
 * @method Invoice firstOr(array $columns = ['*'], \Closure $callback = null)
 * @method Invoice firstWhere(array $column, string|null $operator = null, string|null $value = null, string|null $boolean = 'and')
 * @method Invoice updateOrCreate(array $attributes, array $values = [])
 * @method null|static first(array $columns = ['*'])
 * @method static static findOrFail(string $id, array $columns = ['*'])
 * @method static static findOrNew(string $id, array $columns = ['*'])
 * @method static null|static find(string $id, array $columns = ['*'])
 *
 * @property string $id
 * @property string $number
 * @property Carbon $date
 * @property Carbon $due_date
 * @property string $company_id
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Company $company
 * @property-read Collection $lines
 */
final class Invoice extends Eloquent
{
    use HasTimestamps;
    use HasUuidTrait;
    use HasFactory;

    protected $table = 'invoices';

    protected $keyType = 'string';

    protected $dates = [
        'date',
        'due_date',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'status',
    ];

    protected static function newFactory(): InvoiceFactory
    {
        return InvoiceFactory::new();
    }

    /************************************************
     *                 RELATIONSHIPS                *
     ************************************************/

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class, 'invoice_id', 'id');
    }
}
