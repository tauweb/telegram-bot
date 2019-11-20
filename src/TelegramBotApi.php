<?php
namespace TelegramBot;


use TelegramBot\TelegramRequest;

class TelegramBotApi
{
   use Methods\Message;
   use Methods\Update;

   /** @var string Version number of the Telegram Bot PHP. */
    const VERSION = '1.0.0';

   public function __construct($token){
      $this->token = $token;
   }

   public function sendRequest($method, $params)
   {
       // Здесь какая-то всратая фигня с курлом.... TODO: ПЕРВОСТЕПЕННО РЕШИТЬ ЭТОТ ВОПРОС
       $this->request = (new TelegramRequest())
           ->setAccessToken($this->getAccessToken())
           ->setMethod($method)
           ->setParams($params)
           ->sendRequest();
   }

   public function getAccessToken()
   {
      return $this->token;
   }
}
