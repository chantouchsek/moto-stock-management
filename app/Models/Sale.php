<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Sale extends Model
{
    use SoftDeletes,
        Searchable;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['uuid', 'customer_id', 'user_id', 'is_in_lack', 'in_lack_amount', 'total', 'tax', 'tax_amount'];

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
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'sale_product', 'product_id', 'sale_id')
            ->withPivot([
                'aty',
                'discount',
                'additional_price'
            ])
            ->withTimestamps();
    }
}
