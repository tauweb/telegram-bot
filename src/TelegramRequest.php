<?php

namespace TelegramBot;

//use GuzzleHttp\Client;
//use GuzzleHttp\Psr7\LazyOpenStream;
// use GuzzleHttp\Promise;
// use GuzzleHttp\RequestOptions;
// use GuzzleHttp\ClientInterface;
// use GuzzleHttp\Promise\PromiseInterface;
// use GuzzleHttp\Exception\RequestException;

use TelegramBot\TelegramResponse;

/**
 * Class TelegramRequest.
 *
 * Builds Telegram Bot API Request Entity.
 */
class TelegramRequest
{
    // /** @var string Telegram Bot API URL. */
    const BASE_BOT_URL = 'https://api.telegram.org/bot';

    /** @var string|null The bot access token to use for this request. */
    protected $accessToken;

   /** @var string The HTTP method for this request. */
   protected $method = null;

   /** @var array The headers to send with this request. */
   protected $headers = [];

   /** @var array The parameters to send with this request. */
   protected $params = [];

   /** @var array The files to send with this request. */
   protected $files = [];

//   protected $response;

    /**
     * Creates a new Request entity.
     *setParams
     * @param string|null $accessToken
     * @param string|null $method
     * @param array|null  $params
     */
    public function __construct(
//        $telegramBotApi
//        string $accessToken,
//        string $method = null,
//        array $params = []
        // string $file = null

    ) {
//        $this->telegramBotApi = $telegramBotApi;
//        $this->setAccessToken($accessToken);
//        $this->setMethod($method);
//        $this->setParams($params);
    }

    /**
     * Set the bot access token for this request.
     *
     * @param string $accessToken
     *
     * @return TelegramRequest
     */
    public function setAccessToken(string $accessToken): TelegramRequest
    {
        $this->accessToken = $accessToken;

        return $this;
    }
    /**
     * Set the headers for this request.
     *
     * @param array $headers
     *
     * @return TelegramRequest
     */
    public function setHeaders(array $headers): TelegramRequest
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }
    /**
     * Set the HTTP method for this request.
     *
     * @param string
     *
     * @return TelegramRequest
     */
    public function setMethod(string $method): TelegramRequest
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }
    /**
     * Set the params for this request.
     *
     * @param array $params
     *
     * @return TelegramRequest
     */
    public function setParams(array $params = []): TelegramRequest
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }


    /**
     * Добавляет файл к запросу
     * TODO: Дописать и составить документацию
     *
     * @return TelegramRequest
     */
//    public function uploadFile(string $paramName, string $filePath): TelegramRequest
//    {
//        $file[$paramName][new LazyOpenStream($filePath, 'r')];
//        $this->params = array_merge($this->params, $params);
//    }

    public function sendRequest(/*string $method = null, array $params =[]*/): TelegramResponse
    {
echo self::BASE_BOT_URL . $this->accessToken .'/'.$this->method;

        $url = self::BASE_BOT_URL ;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = array(
            'chat_id' => -1001099783352,
            'text' => 'bar'
        );


        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $contents = curl_exec($ch);
        curl_close($ch);

var_dump($contents);


        if (is_null($this->getMethod())){
            throw new \Exception('Need to set telegram method.'); // TODO: написать обработчик исключений
        }
        if (is_null($this->params)){
            throw new \Exception('Need to set telegram method params.'); // TODO: написать обработчик исключений
        }

        $url = self::BASE_BOT_URL . $this->accessToken .'/'.$this->method;
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
            foreach ($this->params as $key => $value) {
                $optArray[CURLOPT_POSTFIELDS][$key] = $value;
            }
        }

        curl_setopt_array($ch, $optArray);
        $result = json_decode(curl_exec($ch), true);

        curl_close($ch);

var_dump($this);
        $this->httpClentResponse = $result;
        return (new TelegramResponse($this));
    }
}
