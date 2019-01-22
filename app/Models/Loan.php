<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Loan
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $user_id
 * @property int|null $staff_id
 * @property \Illuminate\Support\Carbon|null $needed_date
 * @property string|null $reason
 * @property float|null $amount
 * @property int $is_approved
 * @property int $is_urgent
 * @property \Illuminate\Support\Carbon|null $can_offer_on
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \App\Models\User|null $staff
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Loan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereCanOfferOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereIsUrgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereNeededDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Loan withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Loan withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $is_paid_back
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Loan whereIsPaidBack($value)
 * @property-read string $can_edit
 */
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
        'is_approved',
        'is_paid_back'
    ];

    protected $dates = [
        'can_offer_on',
        'needed_date'
    ];

    /**
     * @var array
     */
    protected $appends = ['can_edit'];

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

    /**
     * @return string
     */
    public function getCanEditAttribute()
    {
        $user = User::find(auth()->id());
        if ($user->hasAnyRole(['Supper Admin', 'Admin'])) {
            return true;
        }
        return false;
    }
}
