<?php 
 
namespace Unodepiera\Simplecart\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class Simplecart extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() 
    { 
        return 'simplecart'; 
    }
 
}