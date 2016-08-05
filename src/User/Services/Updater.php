<?php

namespace Modules\User\Services;

use Modules\User\Entities\User;
use Validator;

/**
 * Class Updater
 * @package Modules\User\Services
 */
class Updater
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param User  $user
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(User $user, array $data)
    {
        return Validator::make($data, [
            'name'      => 'required|max:255|unique:users,name,'.$user->id,
            'email'     => 'required|email|max:255|unique:users,email,'.$user->id,
            'password'  => 'confirmed|min:6',
            'locale'    => 'required|size:2'
        ]);
    }

    /**
     * @param User  $user
     * @param array $data
     *
     * @return bool
     */
    public function update(User $user, array $data)
    {
        $user->fill([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'locale'    => $data['locale'],
        ]);

        // only fill password if specified
        if (array_key_exists('password', $data) && !empty($data['password'])) {
            $user->fill([
                'password' => bcrypt($data['password']),
            ]);
        }

        return $user->save();
    }
}
