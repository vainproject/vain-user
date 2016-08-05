<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vain\Http\Controllers\Controller;

/**
 * Class PasswordController
 * @package Modules\User\Http\Controllers\Auth
 */
class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return view('user::auth.password');
    }

    /**
     * @param null $token
     * @return mixed
     */
    public function getReset( $token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException();
        }

        return view('user::auth.reset')->with('token', $token);
    }
}
