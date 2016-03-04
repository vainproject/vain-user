<?php

namespace Modules\User\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Modules\User\Providers\UserServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            // maybe VainServiceProvider::class is necessary, too?
            UserServiceProvider::class,
        ];
    }
}