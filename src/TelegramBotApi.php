<?php
namespace TelegramBot;


use mysql_xdevapi\Exception;
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
      return $this;
   }

    /**
     * Get instance of the Bots Manager (DI).
     *
     * @param $config
     *
     * @return BotsManager
     */
    public function manager(): BotsManager
    {
        if (!is_object($this->botsManager) and $this->botsManager instanceof BotsManager ){
            throw new \Exception('BotsManager must be instanceof TelegramBot\BotsManager'); // TODO: Написать обработчик исключений
        }
        return $this->botsManager;
    }
    ////////////////////////////////////////////////////////////

   public function sendRequest($method, $params=[])
   {
       // TODO: Здесь лежит TelegramResponse. Может переименовать свойство?
       $this->response = (new TelegramRequest())
           ->setAccessToken($this->getAccessToken())
           ->setMethod($method)
           ->setParams($params)
           ->sendRequest();

       return $this->response;

   }


   public function getAccessToken()
   {
      return $this->token;
   }
}
