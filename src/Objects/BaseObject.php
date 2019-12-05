<?php
namespace TelegramBot\Objects;

use Illuminate\Support\Facades\Log;

abstract class BaseObject {

    public function __construct($data)
    {
        $this->getResult($data);
    }

    private function getResult($data)
    {
        Log::debug(__FUNCTION__,$data);
    }
}
