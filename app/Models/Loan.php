<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Loan extends Model
{
    use SoftDeletes,
        Searchable;

    protected $fillable = [
        'user_id',
        'staff_id',
        'amount',
        'reason',
        'can_offer_on',
        'needed_date',
        'is_urgent',
        'is_approved'
    ];

    protected $dates = [
        'can_offer_on',
        'needed_date'
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
            'is_urgent' => 1,
            'reason' => 1,
            'can_offer_on' => 1,
            'amount' => 5,
            'needed_date' => 5
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
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
