<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Payroll
 *
 * @property-read \App\Models\User $staff
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payroll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payroll withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payroll withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $uuid
 * @property int $user_id
 * @property int $staff_id
 * @property int $over_time
 * @property int $notified
 * @property int|null $hours
 * @property int|null $gross
 * @property float|null $deducted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property float|null $net
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\User $paidBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereDeducted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereOverTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payroll whereUuid($value)
 */
class Payroll extends Model
{
    use SoftDeletes,
        Searchable;


    /**
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_id',
        'staff_id',
        'over_time',
        'hours',
        'total',
        'cross',
        'notified',
        'deducted',
        'net'
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
            'over_time' => 4,
            'hours' => 8,
            'total' => 7,
            'cross' => 8
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
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * @return BelongsTo
     */
    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return float|int
     */
    public function grossPay($user)
    {
        $calc = 0;
        if ($this->staff->full_time && !$this->over_time) {
            return $this->net = $user['net'];
        }
        if ($this->staff->full_time && $this->over_time) {
            $calc = $this->hours * $this->staff->rate;
            return $this->net = $calc + $user['net'];
        }
        if ($this->over_time || !$this->staff->full_time) {
            $calc = $this->hours * $this->staff->rate;
            return $this->net = $calc + $user['net'];
        }
        return $this->net = $calc + $user['net'];
    }
}
