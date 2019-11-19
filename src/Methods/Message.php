<?php

namespace TelegramBot\Methods;

use TelegramBot\TelegramRequest;

trait Message {
    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * @param array $params Мessage data array
     * @return type
     */
    public function sendMessage(array $params) //: TelegramResponse
    {
        $params = [
            'chat_id' => $params['chat_id'],
            'text' => $params['text'],
            'parse_mode' => $params['parse_mode'] ?? 'html',
            'disable_web_page_preview' => $params['disable_web_page_preview'] ?? true,
            'disable_notification' => $params['disable_notification'] ?? true,
            'reply_to_message_id' => $params['reply_to_message_id'] ?? '',
            'reply_markup' => $params['reply_markup'] ?? ''
        ];

//        $this->request = new TelegramRequest(
//            $this->token,
//            __FUNCTION__,
//            $params
//         );
//
//        //  return new TelegramResponse($this->request->sendRequest());
//         return $this->request->sendRequest();

        return $this->sendRequest(__FUNCTION__, $params);
//        return $this->request->sendRequest(__FUNCTION__, $params);
    }
}
