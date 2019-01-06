<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Sale
 *
 * @property int $id
 * @property string|null $uuid
 * @property int|null $customer_id Customer info when selected a customer.
 * @property int|null $user_id Who sole this product.
 * @property int $is_in_lack
 * @property int|null $in_lack_amount Required when is in lack field is true.
 * @property float|null $total
 * @property int|null $tax If needed, can input number percentage of tax will be charged.
 * @property int|null $tax_amount Auto calculate if tax input.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \App\Models\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sale onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereInLackAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereIsInLack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sale withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $color_id
 * @property int|null $product_id
 * @property string|null $engine_number
 * @property string|null $plate_number
 * @property string|null $frame_number
 * @property string|null $customer_name
 * @property float|null $amount
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereEngineNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereFrameNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale wherePlateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereProductId($value)
 */
class Sale extends Model
{
    use SoftDeletes,
        Searchable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'uuid',
        'customer_id',
        'user_id',
        'is_in_lack',
        'in_lack_amount',
        'total',
        'tax',
        'tax_amount',
        'customer_name',
        'price',
        'amount',
        'product_id',
        'date'
    ];

    protected $dates = ['date'];

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
            'is_in_lack' => 1,
            'in_lack_amount' => 1,
            'total' => 2,
            'tax' => 3,
            'tax_amount' => 4
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

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
