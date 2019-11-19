<?php

namespace TelegramBot\Laravel\Controllers\Backend;

use Illuminate\Http\Request;
use TelegramBot\Laravel\Models\Backend\Setting;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        return view('telegramBot::backend.settings', Setting::getSettings());
    }
    
    public function store(Request $request)
    {
        Setting::where('key', '!=', NULL)->delete();

        foreach ($request->except('_token') as $key => $value) {
            $setting = new Setting;
            $setting->key = $key;
            $setting->value = $value;
            $setting->save();
        }
       
        return redirect()->route('tg-admin.setting.index');
    }

    public function setWebhook(Request $request)
    {
        $result = $this->sendTelegramData('setWebhook', [
            'query' => ['url'=> $request->url . '/' . \TelegramBot::getAccessToken()]
        ]);

        return view('telegramBot::backend.settings', ['status' => $result]);
        // return redirect()->route('tg-admin.setting.index')->with('status', $request);
    }

    public function getWebhookInfo(Request $request)
    {
        $result = \TelegramBot::getWebhookInfo()->getBody();
        // $result = $this->sendTelegramData('getWebhookInfo');

        return view('telegramBot::backend.settings', ['status' => $result]);
        // return redirect()->route('tg-admin.setting.index')->with('status', $result);
    }

    public function sendTelegramData(string $route = '', array $params = [], string $method = 'POST')
    {
        $client = new \GuzzleHttp\Client(['base_uri'=>'https://api.telegram.org/bot'.\TelegramBot::getAccessToken().'/']);
        $result = $client->request($method, $route, $params);

        return(string) $result->getBody();
    }
}
