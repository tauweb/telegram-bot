<?php
return [
    "default_bot" => "My Bot",
    "bots"=>[
        "My Bot"=>[
            'username'  => 'TelegramBotToken',
            'token' => env('TELEGRAM_BOT_TOKEN', '902664306:AAEKrd2x4iq86qAmZmfNIidw585Re_1pj_E'),
            'commands' => [
                //Acme\Project\Commands\MyTelegramBot\BotCommand::class
            ],
        ],
    ],
];
