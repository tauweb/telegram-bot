<?php

// var_dump (Illuminate\Support\Facades\Auth);
// Устранить редирект на /home
// Route::middleware(['auth'])
//     ->prefix('tg-admin')
//     ->namespace('TelegramBot\Laravel\Controllers\Backend')
//     ->name('tg-admin.')
//     ->group(function(){
//         Route::get('/','DashboardController@index')->name('index');
//     });

Route::group(['prefix'=>'tg-admin', 'namespace'=>'TelegramBot\Laravel\Controllers\Backend'], function(){
    Route::get('/','DashboardController@index')->name('tg-admin.index');
    Route::get('/setting', 'SettingController@index')->name('tg-admin.setting.index');
    Route::post('/setting/store', 'SettingController@store')->name('tg-admin.setting.store');

    Route::post('/setting/setWebhook', 'SettingController@setWebhook')->name('tg-admin.setting.setWebhook');
    Route::post('/setting/getWebhookInfo', 'SettingController@getWebhookInfo')->name('tg-admin.setting.getWebhookInfo');
});

// Группа
Route::group(['prefix'=>'tg-bot', 'namespace'=>'TelegramBot\Laravel\Controllers'], function(){
    // Route::get('/','DashboardController@index')->name('index');
    // Route::group('prefix'=>'admin', function(){

    // });
});

// Здесь будут компоненты и команды
// Route::post(\TelegramBot::getAccessToken(), function() {
//     TelegramBot::componentsHandler();
// });



// Быстрые тесты
Route::get('foo', function () {
    // $blackjack = -1001082579604;
    // $test = -1001099783352;

    // $t = TelegramBot::sendMessage([
    //     'chat_id'=>$test,
    //     'text'=>time()
    // ]);

    // $s_wb = TelegramBot::setWebhook([
    //     'url' => 'tauweb.ru'
    // ]);
    // var_dump($s_wb->getBody());

    $w_i = TelegramBot::getWebhookInfo();
    var_dump($w_i->getBody());
});
