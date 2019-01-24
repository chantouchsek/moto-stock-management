<?php

namespace App\Models;

use App\Events\Expense\Created;
use App\Events\Expense\Deleted;
use App\Events\Expense\Updated;
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
 * App\Models\Expense
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $user_id
 * @property float|null $amount
 * @property string|null $notes
 * @property string|null $expense_on
 * @property \Illuminate\Support\Carbon|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read \App\Models\User|null $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Expense onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereExpenseOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Expense whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Expense withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Expense withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 */
class Expense extends Model implements HasMedia
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
        'amount' => 'Amount',
        'deleted_at' => 'Deleted At',
        'expense_on' => 'Expense on',
        'date' => 'Date',
        'notes' => 'Notes'
    ];

    /**
     * @var array
     */
    protected $fillable = ['amount', 'expense_on', 'date', 'notes', 'user_id'];


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
     * @var array
     */
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
            'notes' => 3,
            'expense_on' => 1,
            'date' => 10,
            'amount' => 5
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

}
