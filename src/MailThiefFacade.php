<?php

namespace ModernMcGuire\MailThief;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ModernMcGuire\MailThief\Skeleton\SkeletonClass
 */
class MailThiefFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mailthief';
    }
}
