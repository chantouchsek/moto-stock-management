<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Traits\Searchable;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Webpatser\Uuid\Uuid;


/**
 * App\Models\User
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property string|null $phone_number
 * @property string|null $username
 * @property string|null $email_verified_at
 * @property string $password
 * @property int $gender
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $start_work_date
 * @property float|null $base_salary
 * @property string|null $avatar_url
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $resigned_at
 * @property float|null $bonus
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBaseSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereResignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStartWorkDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 * @property string $first_name
 * @property string $last_name
 * @property string|null $bio
 * @property string|null $pay_day
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePayDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User search($search, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchRestricted($search, $restriction, $threshold = null, $entireText = false, $entireTextOnly = false)
 * @property string|null $locale
 * @property-read string $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLocale($value)
 * @property int|null $full_time
 * @property int|null $rate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFullTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRate($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Loan[] $loans
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payroll[] $payrolls
 * @property-read string $user_avatar
 * @property string $staff_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStaffId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserDevice[] $devices
 */
class User extends Authenticatable implements MustVerifyEmail, HasMedia, HasLocalePreference
{
    use Notifiable,
        HasApiTokens,
        SoftDeletes,
        HasRoles,
        Searchable,
        HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_number', 'username', 'date_of_birth',
        'gender', 'address', 'start_work_date', 'base_salary', 'status', 'resigned_at', 'bonus', 'uuid',
        'bio', 'locale', 'full_time', 'rate', 'staff_id'
    ];

    /**
     * @var array
     */
    protected $dates = ['date_of_birth', 'start_work_date', 'resigned_at'];

    /**
     * @var array
     */
    protected $appends = ['full_name', 'user_avatar'];

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
            'users.first_name' => 10,
            'users.last_name' => 10,
            'users.email' => 9,
            'users.address' => 8,
            'users.bio' => 1,
            'users.phone_number' => 6,
            'users.pay_day' => 5
        ]
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string)Uuid::generate(4);
            $lastRecord = User::orderBy('id', 'desc')->withTrashed()->first();
            $model->staff_id = str_pad($lastRecord ? $lastRecord->id + 1 : 1, 10, "0", STR_PAD_LEFT);
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
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * @return string
     */
    public function getUserAvatarAttribute()
    {
        return $this->hasMedia('avatars') ? config('app.url') . $this->getMedia('avatars')->first()->getUrl() : 'http://i.pravatar.cc/500?img=' . $this->id;
    }

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->crop('crop-center', 150, 150)
            ->quality(100)->nonQueued();
    }

    /**
     * Get the preferred locale of the entity.
     *
     * @return string|null
     */
    public function preferredLocale()
    {
        return $this->locale;
    }


    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return HasMany
     */
    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    /**
     * @return HasMany
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class, 'staff_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function devices(): HasMany
    {
        return $this->hasMany(UserDevice::class);
    }

    /**
     * Find the user identified by the given $identifier.
     *
     * @param $identifier
     * @return mixed
     */
    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)
            ->orWhere('staff_id', $identifier)
            ->orWhere('username', $identifier)
            ->orWhere('phone_number', $identifier)->first();
    }

    /**
     * @param $password
     * @return bool
     * @throws OAuthServerException
     */
    public function validateForPassportPasswordGrant($password)
    {
        //check for password
        if (Hash::check($password, $this->getAuthPassword())) {
            //is user active?
            if ($this->status) {
                return true;
            }
            throw new OAuthServerException('User account is not active', 6, 'account_inactive', 401);
        }
        return false;
    }

    /**
     * Route for onesignal
     * @return array
     */
    public function routeNotificationForOneSignal()
    {
        return ['01df94f0-3e76-4710-8a9f-77bc36140ef5'];
    }
}
