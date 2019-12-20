<?php

namespace TelegramBot;

use TelegramBot\Laravel\Facades\TelegramBot;

class TelegramAuth {
    private $botUsername;
    private $telegramUserData;
    private const COOKIE_SESSION_NAME =  'tg_user';

    public function do(string $botName = '')
    {
        if (!$botName)
            $botName = TelegramBot::manager()->getConfig('username');

        if (!$botName)
            return false;

        $this->botUsername = $botName;

        // Пытается получить данные юзера из куки.
        $tgAuthData = $this->getTelegramUserData();
        $this->checkTelegramAuthorization($tgAuthData);

    }


    public function validate(array $telegramUserData = []): bool
    {
        if (!$this->setTelegramAuthUserData($telegramUserData) )
            return false;
    }


    public function getTelegramLoginButton(){
//        $botUsername = TelegramBot::getMe()->getResult()['username'];
        $botUsername = TelegramBot::manager()->getConfig('username');
        // TODO: Вынести во вьюху
        $htmlLoginButton = "<script
                            type=\"application/javascript\"
                            async src=\"https://telegram.org/js/telegram-widget.js?2\"
                            data-telegram-login=\"{$botUsername}\"
                            data-size=\"small\"
                            data-auth-url=\"http://tauweb.ru/test\">
                                // Script body
                            </script>";
        return $htmlLoginButton;
    }

    public function setTelegramAuthUserData(array $telegramUserData)
    {
        $needle = [
            'id' => null,
            'first_name' => null,
            'last_name' => null,
            'username' => null,
            'photo_url' => null,
            'auth_date' => null,
            'hash' => null,
        ];

        if (!isset($telegramUserData['id']) or !isset($telegramUserData['hash']))
            return false;

        foreach ($needle as $key => $value)
            if (array_key_exists($key, $telegramUserData)) {
                $needle[$key] = $telegramUserData[$key];
            } else {
                unset($needle[$key]);
            }

        $this->telegramUserData = $needle;

        return true;
    }

     public function getTelegramAuthUserData()
     {
         if (isset($this->telegramUserData))
             return $this->telegramUserData;

         return false;
     }

    public function checkTelegramAuthorization(array $tgAuthData)
    {
        $checkHash = $tgAuthData['hash'] ?? null;
        unset($tgAuthData['hash']);
        $dataCheckArray = [];

        foreach ($tgAuthData as $key => $value)
            $dataCheckArray[] = $key . '=' . $value;

        sort($dataCheckArray);
        $dataCheckString = implode("\n", $dataCheckArray);
        $secret_key = hash('sha256', $this->token, true);
        $hash = hash_hmac('sha256', $dataCheckString, $secret_key);

        if (strcmp($hash, $checkHash) !== 0)
            return false;
//            throw new \Exception('Data is NOT from Telegram');

        if ((time() - $tgAuthData['auth_date']) > 86400)
            return false;
//            throw new \Exception('Data is outdated');

        $this->saveTelegramUserData($tgAuthData);

        return $tgAuthData;
    }

    public function saveTelegramUserData($tgAuthData)
    {
        $tgAuthData_json = json_encode($tgAuthData);
        setcookie($this->COOKIE_SESSION_NAME, $tgAuthData_json);
    }

    public function getTelegramUserData()
    {
        if (isset($_COOKIE[$this->COOKIE_SESSION_NAME])) {
            $auth_data_json = urldecode($_COOKIE[$this->COOKIE_SESSION_NAME]);
            $auth_data = json_decode($auth_data_json, true);
            return $auth_data;
        }
//        return false;

        if ($_GET['logout']) {
            setcookie($this->COOKIE_SESSION_NAME, '');
            header('Location: '.$_SERVER['SERVER_NAME']);
        }
    }
}
