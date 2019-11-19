<?php
namespace TelegramBot;

use TelegramBot\TelegramBotApi;

class BotsManager
{
    /** @var array The config instance. */
    protected $config;


    /** @var TelegramBotApi[] The active bot instances. */
    protected $bots = [];

    /** @var TelegramBotApi[] The active bot instances. */
    // protected $bots = [];

    /**
     * TelegramManager constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {

        $this->config = $config;
        // return $this;
    }

    /**
     * Get a bot instance.
     *
     * @param string $name
     *
     * @return TelegramBotApi
     */
    public function getBot($name = null): TelegramBotApi
    {
        $name = $name ?? $this->config['default_bot'];

        if (! isset($this->bots[$name])) {
            $this->bots[$name] = $this->makeBot($name);
        }

        return $this->bots[$name];
    }

    /**
     * Make the bot instance.
     *
     * @param string $name
     *
     * @return TelegramBotApi
     */
    protected function makeBot($name): TelegramBotApi
    {
        $config = $this->config['bots'][$name];

        $token = $config['token'];

        $telegram = new TelegramBotApi(
            $token
        );

        return $telegram;
    }
}