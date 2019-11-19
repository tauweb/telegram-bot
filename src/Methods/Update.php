<?php
namespace TelegramBot\Methods;

use TelegramBot\TelegramRequest;
use TelegramBot\TelegramResponse;

trait Update
{
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
            'certificate'       => isset($params['certificate']) ? $this->uploadFile('certificate', $params['certificate']) : null,
            'max_connections'   => $params['max_connections'] ?? 40,
            'allowed_updates'   => $params['allowed_updates'] ?? null
        ];

        $this->request = new TelegramRequest(
            $this->token, 
            __FUNCTION__,
            $params
        );
            
        return $this->request->sendRequest();
    }

    public function getWebhookInfo(): TelegramResponse
    {
        $this->request = new TelegramRequest(
            $this->token,
            __FUNCTION__
        );
            
        return $this->request->sendRequest();  
    }
}