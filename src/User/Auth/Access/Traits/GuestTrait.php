<?php

namespace Modules\User\Auth\Access\Traits;

use Illuminate\Foundation\Auth\Access\Authorizable;

trait GuestTrait
{
    use Authorizable;

    /**
     * Abilities which the guest user posesses
     *
     * @var array
     */
    protected $abilities;

    /**
     * Determine if the entity has a given ability.
     *
     * @param  string $ability
     * @param  array|mixed $arguments
     * @return bool
     */
    public function can($ability, $arguments = [])
    {
        foreach ($this->abilities as $check) {
            if (fnmatch($check, $ability))
                return true;
        }

        return false;
    }
}