<?php
namespace TelegramBot;

//use GuzzleHttp\Client;
//use GuzzleHttp\Psr7\LazyOpenStream;
// use GuzzleHttp\Promise;
// use GuzzleHttp\RequestOptions;
// use GuzzleHttp\ClientInterface;
// use GuzzleHttp\Promise\PromiseInterface;
// use GuzzleHttp\Exception\RequestException;

Class TelegramClient{
    /** @var string Telegram Bot API URL. */
    const BASE_BOT_URL = 'https://api.telegram.org/bot';
    /** @var string|null The bot access token to use for this request. */

   protected $method;
   /** @var array The headers to send with this request. */
   protected $headers = [];
   /** @var array The parameters to send with this request. */
   protected $params = [];
   /** @var array The files to send with this request. */
   protected $files = [];

   public function __construct(
        string $accessToken = env(TELEGRAM_BOT_TOKEN),
        string $method,
        array $params = null,
        $files = null
   )
   {


   }

   public function post(){
       $url = self::BASE_BOT_URL .'bot/' . $this->accessToken .'/'.$this->method;
       $ch = curl_init();
       $optArray = array(
           CURLOPT_SAFE_UPLOAD => true,
           // CURLOPT_HTTPHEADER => array(
           // "Content-Type:multipart/form-data",
           // ),
           CURLOPT_URL => $url,
           CURLOPT_POST => true,
           CURLOPT_RETURNTRANSFER => true,
           // CURLOPT_TIMEOUT => 600,
           CURLOPT_POSTFIELDS => array(
               // Параметры запроса
           )
       );

       // Задаем параметры запроса
       if (isset($this->params) and is_array($this->params)) {
           foreach ($url_params as $key => $value) {
               $optArray[CURLOPT_POSTFIELDS][$key] = $value;
           }
       }

       curl_setopt_array($ch, $optArray);
       $result = json_decode(curl_exec($ch), true);

       curl_close($ch);

       $this->httpClentResponse = $result;
       return (new TelegramResponse($this));

   }
}
