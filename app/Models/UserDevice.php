<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $fillable = ['user_id', 'player_id', 'push_token', 'subscribe', 'device_name', 'country', 'lang_code'];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
