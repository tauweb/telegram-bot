<?php

namespace TelegramBot\Methods;

use TelegramBot\Laravel\Facades\TelegramBot;

trait TelegramAuth {

    private $telegramUserData;
    private $cookieSessionName = 'tg_user';

    public function validate(array $telegramUserData = []): bool
    {
        if (!$this->setTelegramAuthUserData($telegramUserData) )
            return false;
    }


    public function getTelegramLoginButton(){
        $botUsername = $this->getMe()->getResult()['username'];
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
            throw new \Exception('Data is NOT from Telegram');

        if ((time() - $tgAuthData['auth_date']) > 86400)
            throw new \Exception('Data is outdated');

        $this->saveTelegramUserData($tgAuthData);

        return $tgAuthData;
    }

    public function saveTelegramUserData($tgAuthData)
    {
        $tgAuthData_json = json_encode($tgAuthData);
        setcookie($this->cookieSessionName, $tgAuthData_json);
    }

    public function getTelegramUserData()
    {
        if (isset($_COOKIE[$this->cookieSessionName])) {
            $auth_data_json = urldecode($_COOKIE[$this->cookieSessionName]);
            $auth_data = json_decode($auth_data_json, true);
            return $auth_data;
        }
//        return false;

        if ($_GET['logout']) {
            setcookie($this->cookieSessionName, '');
            header('Location: '.$_SERVER['SERVER_NAME']);
        }
    }
}
