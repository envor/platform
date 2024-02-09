<?php

namespace Envor\Platform\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Envor\Platform\Platform
 */
class Platform extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Envor\Platform\Platform::class;
    }
}
