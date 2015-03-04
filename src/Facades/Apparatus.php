<?php namespace Keios\LaravelApparatus\Facades;

use Illuminate\Support\Facades\Facade;

class Apparatus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'apparatus.configuration';
    }
}