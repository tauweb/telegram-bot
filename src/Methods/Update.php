<?php
namespace TelegramBot\Methods;

use TelegramBot\Objects\UpdateObject;
use TelegramBot\TelegramRequest;
use TelegramBot\TelegramResponse;

use Illuminate\Support\Facades\Log;

trait Update
{
    // TODO: ПЕРЕНЕСТИ ОТСЮДА!
    public function getMe()
    {
        return $this->sendRequest(__FUNCTION__);
    }

    public function getUpdates()
    {
        return $this->sendRequest(__FUNCTION__);
    }

    /**
     * Set a Webhook to receive incoming updates via an outgoing webhook.
     *
     * <code>
     * $params = [
     *   'url'         => '',
     *   'certificate' => '',
     *   'max_connections' => '',
     *   'allowed_updates' => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @param array $params [
     *
     * @var string    $url             Required. HTTPS url to send updates to. Use an empty string to remove webhook integration
     * @var InputFile $certificate     Optional. Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
     * @var int       $max_connections Optional. Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot‘s server, and higher values to increase your bot’s throughput.
     * @var array     $allowed_updates Optional. List the types of updates you want your bot to receive. For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all updates regardless of type (default). If not specified, the previous setting will be used.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setWebhook(array $params): TelegramResponse
    {
        $params = [
            'url'               => $params['url'],
//            'certificate'       => isset($params['certificate']) ? $this->uploadFile('certificate', $params['certificate']) : null,
//            'certificate'       => isset($params['certificate']) ? new \CURLFile(realpath($params['certificate'])) : null,
            'certificate'       => $params['certificate'] ?? null,
            'max_connections'   => $params['max_connections'] ?? 40,
//            'allowed_updates'   => $params['allowed_updates'] ?? null
             'allowed_updates'   => isset($params['allowed_updates']) ? json_encode($params['allowed_updates']) : json_encode([])
//            'allowed_updates' => json_encode(['message'])
        ];

        return $this->sendRequest(__FUNCTION__, $params);
    }

    public function deleteWebhook()
    {
        return $this->sendRequest(__FUNCTION__);
    }

    public function getWebhookInfo(): TelegramResponse
    {
        return $this->sendRequest(__FUNCTION__);
    }

    // TODO: Составить доку, здесь получатся апдейты из POST запросов от телеги
    // Получать как-то так:
    //Route::post('/<token>/webhook', function () {
    //    $updates = Telegram::getWebhookUpdates();
    //
    //    return 'ok';
    //});
    /**
     * Returns a webhook update sent by Telegram.
     * Works only if you set a webhook.
     */
    public function getWebhookUpdates(): UpdateObject
    {
        $body = json_decode(file_get_contents('php://input'), true);
        $update = new UpdateObject($body);
//        Log::debug('TelegramWebhool', $body,'tg');
        return $update;
    }
}
