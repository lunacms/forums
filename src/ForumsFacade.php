<?php

namespace Lunacms\Forums;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lunacms\Forums\Skeleton\SkeletonClass
 */
class ForumsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'forums';
    }
}
