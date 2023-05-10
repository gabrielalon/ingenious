<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Entities;

use Carbon\Carbon;
use Database\Factories\Invoice\ProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Money\Currency;
use Money\Price;
use Support\DAO\Contracts\HasUuidTrait;

/**
 * @mixin Builder
 *
 * @method Builder|query()
 * @method make(array $attributes = [])
 * @method create(array $attributes = [])
 * @method forceCreate(array $attributes)
 * @method Product firstOrNew(array $attributes = [], array $values = [])
 * @method Product firstOrFail(array $columns = ['*'])
 * @method Product firstOrCreate(array $attributes, array $values = [])
 * @method Product firstOr(array $columns = ['*'], \Closure $callback = null)
 * @method Product firstWhere(array $column, string|null $operator = null, string|null $value = null, string|null $boolean = 'and')
 * @method Product updateOrCreate(array $attributes, array $values = [])
 * @method null|first(array $columns = ['*'])
 * @method findOrFail(string $id, array $columns = ['*'])
 * @method findOrNew(string $id, array $columns = ['*'])
 * @method static null|static find(string $id, array $columns = ['*'])
 *
 * @property string $id
 * @property string $name
 * @property Price $price
 * @property Currency $currency
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class Product extends Eloquent
{
    use HasTimestamps;
    use HasUuidTrait;
    use HasFactory;

    protected $table = 'products';

    protected $keyType = 'string';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    /************************************************
     *                  ATTRIBUTES                  *
     ************************************************/

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Price::build((int) $value, $this->currency),
            set: fn (Price|int $value) => $value instanceof Price ? $value->cents : $value,
        );
    }

    protected function currency(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Currency::USD(),
            set: fn (Currency|string $value) => $value instanceof Currency ? $value->symbol : $value,
        );
    }
}
