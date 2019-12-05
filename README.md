# telegram-bot
Будет бот для Telegram. 

###Настройки:

Publishing Configs:
`php artisan vendor:publish --tag=config`

In `config/app.php` add `TelegramBot\Laravel\TelegramBotServiceProvider::class` to `'providers'` array
In In `config/app.php` add `'TelegramBot' => TelegramBot\Laravel\Facades\TelegramBot::class` to `'aliases'` array

**To get Updates with Webhook installed in Laravel**

* Cancel the **csrf** token check for the bot. In `app/Http/Middleware/VerifyCsrfToken.php` in the property` $ except` enter your token
```php
    protected $except = [
        '000000000:*', // Or full
        '000000000:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
    ];
```
*  In order for your bot to receive Updates from the Telegram server, you need to specify the route to the `getWebhookUpdates` bot method.
```php
Route::post('<bot_token>', function () {
   $updates = TelegramBot::getWebhookUpdates();

   return 'ok';
});
```

## Пример использования
Standalone:

Laravel:

Set Webhook:
```php
$setWebhook = TelegramBot::setWebhook([
    'url' => 'https://your.domain/BOT_TOKEN',
    'certificate'=> 'ssl/ssl.pem'
]);
// See result
var_dump($setWebhook);
```
Get webhook info:
```php
$webhookInfo = TelegramBot::getWebhookInfo();

var_dump($webhookInfo->getResult());
```
Send message:
```php
$firstMessage = TelegramBot::sendMessage([
    'chat_id'=> env('TELEGRAM_TEST_CHAT_ID'),
    'text' => 'Hello World!'
]);

var_dump($firstMessage->getResult());
```
