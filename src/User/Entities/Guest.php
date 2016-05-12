<?php

namespace Modules\User\Entities;

use Modules\User\Auth\Access\Contracts\GuestInterface as GuestContract;
use Modules\User\Auth\Access\Traits\GuestTrait;

class Guest implements GuestContract
{
    use GuestTrait;

    /**
     * Guest constructor.
     * @param array $abilities
     */
    public function __construct($abilities = [])
    {
        $this->abilities = $abilities;
    }
}
