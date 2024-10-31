<?php

namespace SmartDato\SfExpress\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SmartDato\SfExpress\SfExpress
 */
class SfExpress extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SmartDato\SfExpress\SfExpress::class;
    }
}
