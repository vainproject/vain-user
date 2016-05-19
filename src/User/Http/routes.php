<?php
/*
 * Authentication
 */
Route::group(['namespace' => 'Auth'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('register', ['as' => 'user.auth.register.get', 'uses' => 'AuthController@getRegister']);
        Route::post('register', ['as' => 'user.auth.register.post', 'uses' => 'AuthController@postRegister']);
        Route::get('login', ['as' => 'user.auth.login.get', 'uses' => 'AuthController@getLogin']);
        Route::post('login', ['as' => 'user.auth.login.post', 'uses' => 'AuthController@postLogin']);
        Route::get('logout', ['as' => 'user.auth.logout', 'uses' => 'AuthController@getLogout']);
    });

    Route::group(['prefix' => 'password'], function () {
        Route::get('email', ['as' => 'user.password.email.get', 'uses' => 'PasswordController@getEmail']);
        Route::post('email', ['as' => 'user.password.email.post', 'uses' => 'PasswordController@postEmail']);
        Route::get('reset/{token}', ['as' => 'user.password.reset.get', 'uses' => 'PasswordController@getReset']);
        Route::post('reset', ['as' => 'user.password.reset.post', 'uses' => 'PasswordController@postReset']);
    });

    if (config('services.socialite.enable', false)) {
        // socialite
        Route::group(['prefix' => 'oauth'], function () {
            Route::any('redirect', ['as' => 'social.redirect', 'uses' => 'SocialController@redirect']);
            Route::any('handle', ['as' => 'social.handle', 'uses' => 'SocialController@handle']);
        });
    }
});

/*
 * Frontend
 */
Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('{id}', ['as' => 'user.profile', 'uses' => 'UserController@show']) // only match numeric ids!
        ->where('id', '[0-9]+');

    Route::get('edit', ['as' => 'user.profile.edit', 'uses' => 'UserController@edit']);
    Route::put('edit', ['as' => 'user.profile.update', 'uses' => 'UserController@update']);
});

/*
 * Backend
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('users', 'UserController', ['names' => [
        'index'   => 'user.admin.users.index',
        'create'  => 'user.admin.users.create',
        'store'   => 'user.admin.users.store',
        'show'    => 'user.admin.users.show',
        'edit'    => 'user.admin.users.edit',
        'update'  => 'user.admin.users.update',
        'destroy' => 'user.admin.users.destroy',
    ]]);

    Route::resource('roles', 'RoleController', ['names' => [
        'index'   => 'user.admin.roles.index',
        'create'  => 'user.admin.roles.create',
        'store'   => 'user.admin.roles.store',
        'show'    => 'user.admin.roles.show',
        'edit'    => 'user.admin.roles.edit',
        'update'  => 'user.admin.roles.update',
        'destroy' => 'user.admin.roles.destroy',
    ]]);

    Route::get('permissions', ['as' => 'user.admin.permissions.index', 'uses' => 'PermissionController@index']);
});
