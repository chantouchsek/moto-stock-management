<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $make_id
 * @property int|null $model_id
 * @property int|null $supplier_id
 * @property int|null $category_id
 * @property string|null $name
 * @property string|null $description
 * @property float $price
 * @property float $cost
 * @property int $qty
 * @property string|null $engine_number
 * @property string $color
 * @property string $plat_number If motorbike is second hand
 * @property string $frame_number
 * @property string $status Is new or second hand
 * @property string $code
 * @property int|null $year To track product year
 * @property string|null $import_from
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Make|null $make
 * @property-read \App\Models\Models|null $model
 * @property-read \App\Models\Supplier|null $supplier
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereEngineNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFrameNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereImportFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePlatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withoutTrashed()
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $date_import
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Color[] $colors
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDateImport($value)
 * @property int|null $color_id
 * @property string|null $plate_number If motorbike is second hand
 * @property string|null $sole_on
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePlateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSoleOn($value)
 */
class Product extends Model implements HasMedia
{
    use SoftDeletes,
        Searchable,
        HasMediaTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'cost',
        'supplier_id',
        'make_id',
        'color_id',
        'model_id',
        'year',
        'import_from',
        'date_import',
        'engine_number',
        'plate_number',
        'frame_number',
        'status',
        'code',
        'sole_on'
    ];

    /**
     * @var array
     */
    protected $dates = ['date_import', 'sole_on'];

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
            'products.id' => 10,
            'products.name' => 9,
            'products.description' => 1,
            'products.engine_number' => 10,
            'products.frame_number' => 9
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
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    /**
     * @return BelongsTo
     */
    public function make(): BelongsTo
    {
        return $this->belongsTo(Make::class)->withTrashed();
    }

    /**
     * @return BelongsTo
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(Models::class)->withTrashed();
    }

    /**
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

    /**
     * @return BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class)->withTrashed();
    }


    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('product-image-featured')->quality(100)->nonQueued();
    }

}
