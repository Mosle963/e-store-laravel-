<?php

namespace App\Facades;

use App\Services\CartService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Cart
 *
 * This class acts as a facade for the CartService. It allows you to use the
 * CartService methods statically via the Facade.
 */
class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * This method returns the fully qualified class name of the service
     * container binding that should be resolved when the facade is called.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CartService::class;
    }
}
