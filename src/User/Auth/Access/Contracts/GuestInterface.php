<?php

namespace Modules\User\Auth\Access\Contracts;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

interface GuestInterface extends AuthorizableContract
{
    /**
     * Determine if the entity does not have a given ability.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     * @return bool
     */
    public function cant($ability, $arguments = []);

    /**
     * Determine if the entity does not have a given ability.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     * @return bool
     */
    public function cannot($ability, $arguments = []);
}