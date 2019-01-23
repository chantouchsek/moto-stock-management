<?php

namespace App\Models;

use App\Events\Sale\Created;
use App\Events\Sale\Deleted;
use App\Events\Sale\Updated;
use App\Traits\RevisionableUpgrade;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Venturecraft\Revisionable\RevisionableTrait;
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
 * @property string|null $sale_no
 * @property float|null $price
 * @property \Illuminate\Support\Carbon|null $date
 * @property string|null $notes
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sale whereSaleNo($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 */
class Sale extends Model implements HasMedia
{
    use SoftDeletes,
        Searchable,
        HasMediaTrait,
        RevisionableTrait,
        RevisionableUpgrade;

    /**
     * @var bool
     */
    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 1000;
    protected $revisionNullString = 'nothing';
    protected $revisionUnknownString = 'unknown';

    /**
     * @var array
     */
    protected $revisionFormattedFieldNames = [
        'in_lack_amount' => 'In lack amount',
        'is_in_lack' => 'Is in lack',
        'deleted_at' => 'Deleted At',
        'price' => 'Price',
        'total' => 'Total',
        'date' => 'Date',
        'notes' => 'Notes',
        'customer_name' => "Customer name",
        'tax_amount' => "Tax amount"
    ];

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
        'date',
        'notes',
        'sale_no'
    ];

    /**
     * @var array
     */
    protected $dates = ['date'];


    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array The event mapping.
     */
    protected $dispatchesEvents = [
        'created' => Created::class,
        'updated' => Updated::class,
        'deleted' => Deleted::class
    ];

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
            'sales.is_in_lack' => 1,
            'sales.in_lack_amount' => 1,
            'sales.total' => 2,
            'sales.tax' => 3,
            'sales.tax_amount' => 4,
            'sales.price' => 10,
            'customers.first_name' => 9,
            'customers.last_name' => 9,
            'sales.date' => 8,
            'sales.sale_no' => 10
        ],
        'joins' => [
            'customers' => ['sales.customer_id', 'customers.id']
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
            $lastRecord = Sale::orderBy('id', 'desc')->withTrashed()->first();
            $model->sale_no = str_pad($lastRecord ? $lastRecord->id + 1 : 1, 10, "0", STR_PAD_LEFT);
        });
    }


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        if (request()->expectsJson()) {
            return 'uuid';
        }
        return 'id';
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


    public function hasRevision()
    {
        return $this->revisionHistory()->where('revisionable_id', '=', $this->id);
    }
}
