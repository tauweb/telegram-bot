<?php
namespace TelegramBot;

use PHPUnit\Framework\MockObject\Method;
use TelegramBot\TelegramRequest;

class TelegramBotApi
{
    use Methods\Message;
    use Methods\Update;

    /** @var string Version number of the Telegram Bot PHP. */
    const VERSION = '1.0.0';

    /**
     * @var TelegramResponse
     */
    private $response;

    private $token;

    private $botsManager;

    public function __construct($token, BotsManager $botsManager = null)
    {
        $this->token = $token;
        $this->botsManager = $botsManager;
    }

    /**
     * Get instance of the Bots Manager (DI).
     *
     * @param array $config The bots config
     *
     * @return BotsManager
     */
    public function manager(): BotsManager
    {
        if ( !is_object($this->botsManager) and !($this->botsManager instanceof BotsManager) )
            throw new \Exception('BotsManager must be instanceof TelegramBot\BotsManager'); // TODO: Написать обработчик исключений

        return $this->botsManager;
    }

    public function sendRequest(string $method, array $params = []): TelegramResponse
    {
       	$this->response = (new TelegramRequest())
        	->setAccessToken($this->getAccessToken())
			->setMethod($method)
			->setParams($params)
			->sendRequest();

       	return $this->response;
    }

    public function getAccessToken() {return $this->token;}

    /**
     * The magic method to call undescribed methods in the API (For dev)
     *
     * @param string $name name of the telegram method to request
     * @param array $arguments
     * @return TelegramResponse
     */
    public function __call(string $name, array $arguments = []): TelegramResponse
    {
		return $this->sendRequest($name, $arguments[0] ?? []);
    }
}
