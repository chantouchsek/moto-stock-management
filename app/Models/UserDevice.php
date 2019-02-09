<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\UserDevice
 *
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserDevice query()
 * @mixin \Eloquent
 */
class UserDevice extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'player_id', 'push_token', 'subscribe', 'device_name', 'country', 'lang_code'];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


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
}
