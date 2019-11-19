
namespace TelegramBot;

_trait Methods {
    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     * @param array $data Мessage data array
     * @return type
     */
    public function sendMessage(array $data) //: TelegramResponse
    {
        $data = [
            'chat_id' => $data['chat_id'],
            'text' => $data['text'],
            'parse_mode' => $data['parse_mode'] ?? 'html',
            'disable_web_page_preview' => $data['disable_web_page_preview'] ?? true,
            'disable_notification' => $data['disable_notification'] ?? true,
            'reply_to_message_id' => $data['reply_to_message_id'] ?? '',
            'reply_markup' => $data['reply_markup'] ?? ''
        ];
        
        $this->request = new TelegramRequest(
            $this->token, 
            __FUNCTION__,
            $data
         );
         
        //  return new TelegramResponse($this->request->sendRequest());
         return $this->request->sendRequest();

    }
}