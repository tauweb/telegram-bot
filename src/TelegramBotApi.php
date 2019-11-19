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

//       $this->request = new TelegramRequest(
//          $this
//       );

      // $this->request->sendRequest('sendMessage',
      // ['chat_id'=>-1001099783352,'text'=>time()]);
   }

   public function sendRequest($method, $params)
   {
       $this->request = (new TelegramRequest())
           ->setAccessToken($this->getAccessToken())
           ->setMethod($method)
           ->setParams($params)
        ->sendRequest();
   }

   public static function test($message = 'Sample message'){
      echo $message;
   }

   public function getAccessToken()
   {
      return $this->token;
   }

}
