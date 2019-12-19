<?php
namespace TelegramBot;

use TelegramBot\TelegramBotApi;

class BotsManager
{
    /** @var array The config instance. */
    protected $config;

    /** @var TelegramBotApi[] The active bot instances. */
    protected $bots = [];

    /** @var string Name of the last bot instances. */
    protected $currentBot;

    /**
     * TelegramManager constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        // Getting the default config for Laravel.
        if (empty($config) and function_exists('app')) {
            $config = app('config')->get('telegrambot');
        } else {
            // Getting the default config for standalone usage.
            $config = include(__DIR__.'/config/telegrambot.php');
        }

        $this->config = $config;
    }

    /**
     * Get a bot instance.
     *
     * @param string $name
     *
     * @return TelegramBotApi
     */
    public function getBot(string $name = null): TelegramBotApi
    {
        $name = $name ?? $this->config['default_bot'];
        $this->currentBot = $name;

        if (! isset($this->bots[$name]))
            $this->bots[$name] = $this->makeBot($name);

        return $this->bots[$name];
    }

    /**
     * Make the bot instance.
     *
     * @param string $name
     *
     * @return TelegramBotApi
     */
    protected function makeBot(string $name): TelegramBotApi
    {
        $config = $this->config['bots'][$name];
        $token = $config['token'];
        $telegramBot = new TelegramBotApi($token, $this);

        return $telegramBot;
    }

    public function getCurrentBotName(): string
    {
        if(!$this->currentBot)
            throw new \Exception('You must first create a bot instance BotsManager->getBot()'); // TODO: Написать обработчик исключений

        return $this->currentBot;
    }
}
