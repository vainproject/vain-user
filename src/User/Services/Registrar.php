<?php

namespace Modules\User\Services;

use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Modules\User\Entities\User;
use Validator;

/**
 * Class Registrar
 * @package Modules\User\Services
 */
class Registrar implements RegistrarContract
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => 'required|max:255|unique:users',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|confirmed|min:6',
            'locale'    => 'required|size:2',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'locale'    => $data['locale'],
            'password'  => bcrypt($data['password']),
        ]);

        return $user;
    }
}
