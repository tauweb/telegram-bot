<?php

namespace TelegramBot;

// TODO: Отказ от Guzzle
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

   /** @var @var Ответ с сервера  */
   protected $httpClientResponse;

   protected $curlParams = [];

   protected $proxy;

    /**
     * Creates a new Request entity.
     *setParams
     * @param string|null $accessToken
     * @param string|null $method
     * @param array|null  $params
     */
    public function __construct(
//        $telegramBotApi
//        string $accessToken,использования
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
     * @param array $params
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
     * @return TelegramRequest
     */
//    public function uploadFile(string $paramName, string $filePath): TelegramRequest
//    {
//        $file[$paramName][new LazyOpenStream($filePath, 'r')];
//        $this->params = array_merge($this->params, $params);
//    }

    public function getHttpClientResponse(){
        return $this->httpClientResponse;
    }

    public function setProxy(string $proxyAddr, string $proxyType = CURLPROXY_SOCKS5): TelegramRequest
    {
        $this->curlParams[CURLOPT_PROXY] = $proxyAddr;
        $this->curlParams[CURLOPT_SSL_VERIFYPEER] = false;
        $this->curlParams[CURLOPT_PROXYTYPE] = $proxyType;
        return $this;
    }

    public function sendRequest(/*string $method = null, array $params =[]*/): TelegramResponse
    {
        $attachments = ['certificate', 'photo', 'sticker', 'audio', 'document', 'video'];

        foreach ($attachments as $attachment) {
            if (isset($this->params[$attachment])) {
                $this->params[$attachment] = $this->curlFile($this->params[$attachment]);
                break;
            }
        }

        $curlParams = [
            CURLOPT_SAFE_UPLOAD => true,
            CURLOPT_URL => self::BASE_BOT_URL . $this->accessToken .'/'.$this->method,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $this->params
        ];

        $this->curlParams = array_merge_recursive_distinct($this->curlParams, $curlParams);

        $handle = curl_init();
        curl_setopt_array($handle, $this->curlParams);
        $response = curl_exec($handle);
        $err = curl_error($handle);

        if ($response === false) {
            $errno = curl_errno($handle);
            $error = curl_error($handle);
//            error_log("Curl returned error $errno: $error\n");
            curl_close($handle);
            throw new \Exception("No respone from telegram server: $errno: $error\n."); // TODO: написать обработчик исключений
//            return false;
        }

        $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
        curl_close($handle);

        $this->httpClientResponse = $response;
        return (new TelegramResponse($this));
    }

    private function curlFile($path) {
//        if (is_array($path))
//            return $path['file_id'];

        $realPath = realpath($path);

        if (class_exists('CURLFile')) {
            $curlFile = new \CURLFile($realPath);
        }

        // если не файл (например передан file_id или нет такого файла)
        if ($curlFile->name !== '') {
            return $curlFile;
        }

        return $path;

//        if (class_exists('CURLFile'))
//            return new \CURLFile($realPath);
//
//        return '@' . $realPath;
    }
}
