<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;
use Modules\User\Auth\Access\Contracts\RoleInterface as RoleContract;
use Modules\User\Auth\Access\Traits\RoleTrait;

/**
 * Class Role
 * @package Modules\User\Entities
 */
class Role extends Model implements RoleContract
{
    use RoleTrait, LocalizedEloquentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description', 'color', 'order'];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrdered( $query)
    {
        return $query->orderBy('order', 'ASC');
    }
}
