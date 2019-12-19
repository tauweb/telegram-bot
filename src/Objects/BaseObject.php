<?php
namespace TelegramBot\Objects;

use Illuminate\Support\Facades\Log;

abstract class BaseObject {

	private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    private function getResult($data)
    {
        Log::debug(__FUNCTION__,$data);
    }
    
}
