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
//        var_dump($request);
        $this->response = $request->getHttpClientResponse();
//        $this->body = $this->getBody();
//        $this->decodeBody();
        var_dump($this);die();
    }

    /**
     * Converts raw API response to proper decoded response.
     */
    public function decodeBody()
    {
        $this->decodedBody = json_decode($this->body, true);

        if ($this->decodedBody === null) {
            $this->decodedBody = [];
            parse_str($this->body, $this->decodedBody);
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
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Helper function to return the payload of a successful response.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->decodedBody['result'];
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
}
