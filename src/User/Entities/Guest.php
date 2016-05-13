<?php

namespace Modules\User\Entities;

use Modules\User\Auth\Access\Contracts\GuestInterface as GuestContract;
use Modules\User\Auth\Access\Exceptions\GuestImmutableException;
use Modules\User\Auth\Access\Traits\GuestTrait;

class Guest implements GuestContract
{
    use GuestTrait;

    /**
     * Guest constructor.
     *
     * @param array $roles
     * @param array $abilities
     */
    public function __construct($roles = [], $abilities = [])
    {
        $this->roles = $roles;
        $this->abilities = $abilities;
    }


    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @throws GuestImmutableException
     */
    public function roles()
    {
        throw new GuestImmutableException("you can not modify the guest object nor use any eloquent related methods");
    }

    /**
     * Save the inputted roles.
     *
     * @param mixed $inputRoles
     * @throws GuestImmutableException
     */
    public function saveRoles($inputRoles)
    {
        throw new GuestImmutableException("you can not modify the guest object nor use any eloquent related methods");
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
        return false;
    }
}
