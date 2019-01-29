<?php

namespace App\Models;

use App\Events\Category\Created;
use App\Events\Category\Deleted;
use App\Events\Category\Updated;
use App\Traits\RevisionableUpgrade;
use App\Traits\Searchable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $description
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $uuid
 * @property int|null $parent_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 */
class Category extends Model
{
    use SoftDeletes,
        Sluggable,
        Searchable,
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
        'name' => 'Name',
        'description' => 'Description',
        'active' => 'Active',
        'deleted_at' => 'Deleted At'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'active', 'uuid', 'parent_id'
    ];

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
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

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
            'categories.name' => 10,
            'categories.description' => 1
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
     * @return HasMany
     */
    public function makes(): HasMany
    {
        return $this->hasMany(Make::class);
    }

}
