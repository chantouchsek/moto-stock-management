<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Make
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Make newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Make newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Make query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Make search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Make searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Make onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Make withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Make withoutTrashed()
 */
class Make extends Model
{
    use Searchable, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'active', 'uuid'
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
            'name' => 10,
            'description' => 8,
            'active' => 1
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
}
