<?php

namespace TelegramBot\Methods;

use TelegramBot\TelegramResponse;

trait Message {
    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * @param array $params Мessage data array
     * @return type
     */
    public function sendMessage(array $params): TelegramResponse
    {
        $params = [
            'chat_id'                   => $params['chat_id'],
            'text'                      => $params['text'],
            'parse_mode'                => $params['parse_mode'] ?? 'html',
            'disable_web_page_preview'  => $params['disable_web_page_preview'] ?? false,
            'disable_notification'      => $params['disable_notification'] ?? false,
            'reply_to_message_id'       => $params['reply_to_message_id'] ?? null,
            'reply_markup'              => $params['reply_markup'] ?? null
        ];

        return $this->sendRequest(__FUNCTION__, $params);
    }

    public function forwardMessage(array $params): TelegramResponse
    {
        $params = [
            'chat_id'               => $params['chat_id'],
            'from_chat_id'          => $params['from_chat_id'],
            'disable_notification'  => $params['disable_notification'] ?? false,
            'message_id'            => $params['message_id']
        ];

        return $this->sendRequest(__FUNCTION__, $params);
    }

    public function sendPhoto(array $params): TelegramResponse
    {
        $params = [
            'chat_id'               => $params['chat_id'],
            'photo'                 => $params['photo'], // TODO: Input File or string
            'caption'               => $params['caption'] ?? null,
            'parse_mode'            => $params['parse_mode'] ?? null,
            'disable_notification'  => $params['disable_notification'] ?? false,
            'reply_to_message_id'   => $params['reply_to_message_id'] ?? null,
            'reply_markup'          => $params['reply_markup'] ?? null,
        ];

        return $this->sendRequest(__FUNCTION__, $params);
    }

    public function sendAudio(array $params): TelegramResponse
    {
        $params = [
            'chat_id'               => $params['chat_id'],
            'audio'                 => $params['audio'], // TODO: Input File or string
            'caption'               => $params['caption'] ?? null,
            'parse_mode'            => $params['parse_mode'] ?? 'html',
            'duration'              => $params['duration'] ?? null,
            'performer'             => $params['performer'] ?? null,
            'title'                 => $params['title'] ?? null,
            'thumb'                 => $params['thumb'] ?? null, // TODO: Input File or string
            'disable_notification'  => $params['disable_notification'] ?? null,
            'reply_to_message_id'   => $params['reply_to_message_id'] ?? null,
            'reply_markup'          => $params['reply_markup'] ?? null
        ];

        return $this->sendRequest(__FUNCTION__, $params);
    }

    public function sendDocument(array $params): TelegramResponse
    {
        $params = [
            'chat_id'               => $params['chat_id'],
            'document'              => $params['document'], // TODO: Input File or string
            'thumb'                 => $params['thumb'] ?? null, // TODO: Input File or string
            'caption'               => $params['caption'] ?? null,
            'parse_mode'            => $params['parse_mode'] ?? 'html',
            'disable_notification'  => $params['disable_notification'] ?? null,
            'reply_to_message_id'   => $params['reply_to_message_id'] ?? null,
            'reply_markup'          => $params['reply_markup'] ?? null
            ];

        return $this->sendRequest(__FUNCTION__, $params);
    }

    public function sendVideo(array $params): TelegramResponse
    {
        $params = [
            'chat_id'               => $params['chat_id'],
            'video'                 => $params['video'], // TODO: Input File or string
            'duration'              => $params['duration'] ?? null,
            'width'                 => $params['width'] ?? null,
            'height'                => $params['height'] ?? null,
            'thumb'                 => $params['thumb'] ?? null, // TODO: Input File or string
            'caption'               => $params['caption'] ?? null,
            'parse_mode'            => $params['parse_mode'] ?? 'html',
            'supports_streaming'    => $params['supports_streaming'] ?? null,
            'disable_notification'  => $params['disable_notification'] ?? null,
            'reply_to_message_id'   => $params['reply_to_message_id'] ?? null,
            'reply_markup'          => $params['reply_markup'] ?? null
            ];

        return $this->sendRequest(__FUNCTION__, $params);
    }

    public function sendAnimation(array $params): TelegramResponse
    {
        $params = [
            'chat_id'               => $params['chat_id'],
            'animation'             => $params['animation'], // TODO: Input File or string
            'duration'              => $params['duration'] ?? null,
            'width'                 => $params['width'] ?? null,
            'height'                => $params['height'] ?? null,
            'thumb'                 => $params['thumb'] ?? null, // TODO: Input File or string
            'caption'               => $params['caption'] ?? null,
            'parse_mode'            => $params['parse_mode'] ?? 'html',
            'disable_notification'  => $params['disable_notification'] ?? null,
            'reply_to_message_id'   => $params['reply_to_message_id'] ?? null,
            'reply_markup'          => $params['reply_markup'] ?? null
        ];

        return $this->sendRequest(__FUNCTION__, $params);
    }

    public function sendVoice(array $params): TelegramResponse
    {
        $params = [
            'chat_id'               => $params['chat_id'],
            'voice'                 => $params['voice'], // TODO: Input File or string
            'caption'               => $params['caption'] ?? null,
            'parse_mode'            => $params['parse_mode'] ?? 'html',
            'duration'              => $params['duration'] ?? null,
            'disable_notification'  => $params['disable_notification'] ?? null,
            'reply_to_message_id'   => $params['reply_to_message_id'] ?? null,
            'reply_markup'          => $params['reply_markup'] ?? null
            ];

        return $this->sendRequest(__FUNCTION__, $params);
    }
}
