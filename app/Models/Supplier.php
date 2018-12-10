<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Supplier
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $name
 * @property string|null $email
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $start_provide_date
 * @property string|null $phone_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereStartProvideDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Supplier searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 */
class Supplier extends Model
{
    use SoftDeletes, Searchable;

    protected $fillable = ['uuid', 'name', 'start_provide_date', 'address', 'email', 'phone_number'];

    protected $dates = ['start_provide_date'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'suppliers.name' => 10,
            'suppliers.email' => 9,
            'suppliers.address' => 8,
            'suppliers.start_provide_date' => 7,
            'phone_number' => 6
        ]
    ];


    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string)Uuid::generate(4);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
