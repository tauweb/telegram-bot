<?php
namespace TelegramBot;

use TelegramBot\TelegramRequest;

class TelegramResponse {

    /** @var TelegramRequest The original request that returned this response. */
    protected $request;

    protected $response;

    protected $decodedBody;

    public function __construct(TelegramRequest $request)
    {
        $this->request = $request;
        $this->response = $request->getHttpClientResponse();
//        $this->body = $this->getBody();
        $this->decodeBody();
//        var_dump($this);die();
    }

    /**
     * Converts raw API response to proper decoded response.
     */
    public function decodeBody()
    {
        $this->decodedBody = json_decode($this->response, true);

        if ($this->decodedBody === null) {
            $this->decodedBody = [];
            parse_str($this->response, $this->decodedBody);
        }

        if (! is_array($this->decodedBody)) {
            $this->decodedBody = [];
        }
    }

    /**
     * Return the raw body response.
     *
     * @return string
     */
    public function getBody(bool $json = false)
    {
        return $json ? json_encode($this->decodedBody) : $this->decodedBody;
//        return $this->decodedBody;
    }

    /**
     * Helper function to return the payload of a successful response.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->decodedBody['result'];

//        if (isset($this->decodedBody['result'])){
//            return $this->decodedBody['result'];
//        }elseif (!$this->isError()){
//            throw new \Exception('No any result or error from server'); // TODO: Exception
//        }elseif (isError()){
//            return $this->getError();
//        }

    }

    /**
     * Checks if response is an error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return isset($this->decodedBody['ok']) && ($this->decodedBody['ok'] === false);
    }


    /**
     * Get the telegram response error.
     *
     * @return mixed false or telegram request error info array
     */
    public function getError()
    {
        return $this->isError() ? $this->decodedBody : false;
    }
}
