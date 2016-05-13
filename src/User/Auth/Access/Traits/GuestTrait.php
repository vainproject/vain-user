<?php

namespace Modules\User\Auth\Access\Traits;

use Illuminate\Foundation\Auth\Access\Authorizable;

trait GuestTrait
{
    use Authorizable;

    /**
     * Roles which the guest user posesses.
     *
     * @var array
     */
    protected $roles;

    /**
     * Abilities which the guest user posesses.
     *
     * @var array
     */
    protected $abilities;

    /**
     * Determine if the entity has a given ability.
     *
     * @param string      $ability
     * @param array|mixed $arguments
     *
     * @return bool
     */
    public function can($ability, $arguments = [])
    {
        foreach ($this->abilities as $check) {
            if (fnmatch($check, $ability)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the user has a role by its name.
     *
     * @param string|array $name Role name or array of role names.
     *
     * @return bool
     */
    public function hasRole($name)
    {
        if (is_string($name)) {
            return collect($this->roles)->contains($name);
        }

        return (bool) collect($this->roles)->intersect($name->lists('name'))->count();
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $role
     */
    public function attachRole($role)
    {
        $this->attachRoles((array) $role);
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $role
     */
    public function detachRole($role)
    {
        $this->detachRoles((array) $role);
    }

    /**
     * Attach multiple roles to a user.
     *
     * @param mixed $roles
     */
    public function attachRoles($roles)
    {
        collect($this->roles)->merge($roles);
    }

    /**
     * Detach multiple roles from a user.
     *
     * @param mixed $roles
     */
    public function detachRoles($roles)
    {
        collect($this->roles)->forget($roles);
    }
}
