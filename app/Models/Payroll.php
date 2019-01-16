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
        'notified'
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
    public function grossPay()
    {
        $calc = 0;
        if ($this->staff->full_time && !$this->over_time) {
            return $this->gross = $this->staff->base_salary;
        }
        if ($this->staff->full_time && $this->over_time) {
            $calc = $this->hours * $this->staff->rate;
            return $this->gross = $calc + $this->staff->base_salary;
        }
        if ($this->over_time || !$this->staff->full_time) {
            $calc = $this->hours * $this->staff->rate;
            return $this->gross = $calc + $this->staff->base_salary;
        }
        return $this->gross = $calc + $this->staff->base_salary;
    }
}
