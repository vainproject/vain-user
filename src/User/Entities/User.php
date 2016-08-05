<?php

namespace Modules\User\Entities;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;
use Modules\User\Auth\Access\Contracts\UserInterface as UserContract;
use Modules\User\Auth\Access\Traits\UserTrait;
use Modules\User\Observers\UserObserver;

/**
 * Class User
 * @package Modules\User\Entities
 */
class User extends Model implements UserContract, AuthenticatableContract, CanResetPasswordContract
{
    use UserTrait, Authenticatable, CanResetPassword, SoftDeletes, LocalizedEloquentTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_active_at'];

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        self::observe(UserObserver::class);
    }

    /**
     * created static pages.
     *
     * todo make site module trait to include in user entity
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function sites()
    {
        if (!class_exists(\Modules\Site\Entities\Page::class, false)) {
            throw new \Exception('in order to use User::sites() you have to install the \'vain-sites\' module');
        }

        return $this->hasMany(\Modules\Site\Entities\Page::class);
    }

    /**
     * todo make blog module trait to include in user entity.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function posts()
    {
        if (!class_exists(\Modules\Blog\Entities\Post::class, false)) {
            throw new \Exception('in order to use User::posts() you have to install the \'vain-blog\' module');
        }

        return $this->hasMany(\Modules\Blog\Entities\Post::class);
    }

    /**
     * todo make blog module trait to include in user entity.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function comments()
    {
        if (!class_exists(\Modules\Blog\Entities\Comment::class, false)) {
            throw new \Exception('in order to use User::comments() you have to install the \'vain-blog\' module');
        }

        return $this->hasMany(\Modules\Blog\Entities\Comment::class);
    }

    /**
     * queries all possible online users.
     *
     * @param $query
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeOnline($query)
    {
        $expiryDate = Carbon::now()
            ->subMinutes(config('session.lifetime'));

        return $query->where('last_active_at', '>', $expiryDate)
            ->andWhere('logged_out', false);
    }

    /**
     * accessor for current online state.
     *
     * @param $value
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getOnlineAttribute($value)
    {
        $expiryDate = Carbon::now()
            ->subMinutes(config('session.lifetime'));

        return (!$this->logged_out)
            && $expiryDate->lt($this->last_active_at);
    }

    /**
     * accessor for the users avatar.
     *
     * @param $value
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getAvatarAttribute($value)
    {
        return $this->getAvatar();
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        // TODO user option for gravatar && check and maybe provide own avatar engine

        return app('Modules\User\Services\Gravatar')
            ->getGravatar($this->email);
    }

    /**
     * Save the model to the database without updating
     * the timestamps.
     *
     * @param array $options
     *
     * @return bool
     */
    public function saveWithoutTimestamps(array $options = [])
    {
        $this->timestamps = false; // don't update updated_at
        $this->save($options);

        $this->timestamps = true; // forgetting this may result in unexpected behavior
    }

    /**
     * Checks for the property user_id and compares it to the id of this user object.
     *
     * @param object $object
     *
     * @return bool
     */
    public function owns($object)
    {
        return property_exists($object, 'user_id') && $object->user_id == $this->id;
    }
}
