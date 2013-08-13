<?php namespace GrahamCampbell\HTMLMin\Facades;

use Illuminate\Support\Facades\Facade;

class HTMLMin extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'htmlmin'; }

}
