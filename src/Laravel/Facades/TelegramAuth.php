<?php

namespace TelegramBot\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class TelegramBot.
 */
class TelegramAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'telegramAuth';
    }
}
