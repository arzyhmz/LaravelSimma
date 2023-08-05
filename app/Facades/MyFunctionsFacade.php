<?php
// app\Facades\MyFunctionsFacade.php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MyFunctionsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'myfunctions'; // This should match the binding key in the service provider
    }
}

?>