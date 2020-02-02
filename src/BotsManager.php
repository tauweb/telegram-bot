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
    protected $currentBotName;

    /**
     * TelegramManager constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        // Getting the default config for Laravel or standalone.
        if (empty($config) and function_exists('config'))
            $config = config('telegrambot');
        elseif (empty($config))
            $config = include(__DIR__.'/config/telegrambot.php');

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
        $this->currentBotName = $name ?? $this->config['default_bot'];

        if (!isset($this->bots[$this->currentBotName]))
            $this->bots[$this->currentBotName] = $this->makeBot($this->currentBotName);

        return $this->bots[$this->currentBotName];
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

    public function getConfig(string $key = '')
    {
        if(!$this->currentBotName)
            throw new \Exception('You must first create a bot instance BotsManager->getBot()'); // TODO: Написать обработчик исключений

//        $key = 'name.ts';
//
//        $keys = explode('.', $key)
//        for ($i = 0; $i <= count($keys) ; $i++){
//            echo
//        }
//        die();

        if ($key == 'name')
            return $this->currentBotName;



        return $key ? $this->config['bots'][$this->currentBotName][$key] : $this->config['bots'][$this->currentBotName];
    }
}
