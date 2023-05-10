<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Entities;

use Carbon\Carbon;
use Database\Factories\Invoice\CompanyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Support\DAO\Contracts\HasUuidTrait;

/**
 * @mixin Builder
 *
 * @method static Builder|static query()
 * @method static static make(array $attributes = [])
 * @method static static create(array $attributes = [])
 * @method static static forceCreate(array $attributes)
 * @method Company firstOrNew(array $attributes = [], array $values = [])
 * @method Company firstOrFail(array $columns = ['*'])
 * @method Company firstOrCreate(array $attributes, array $values = [])
 * @method Company firstOr(array $columns = ['*'], \Closure $callback = null)
 * @method Company firstWhere(array $column, string|null $operator = null, string|null $value = null, string|null $boolean = 'and')
 * @method Company updateOrCreate(array $attributes, array $values = [])
 * @method null|static first(array $columns = ['*'])
 * @method static static findOrFail(string $id, array $columns = ['*'])
 * @method static static findOrNew(string $id, array $columns = ['*'])
 * @method static null|static find(string $id, array $columns = ['*'])
 *
 * @property string $id
 * @property string $name
 * @property string $street
 * @property string $city
 * @property string $zip
 * @property string $phone
 * @property string $email
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class Company extends Eloquent
{
    use HasTimestamps;
    use HasUuidTrait;
    use HasFactory;

    protected $table = 'companies';

    protected $keyType = 'string';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected static function newFactory(): CompanyFactory
    {
        return CompanyFactory::new();
    }
}
