<?php
namespace TelegramBot\Laravel\Controllers;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class TelegramBotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function index() {
        return view('TelegramBot::index');
    }
}
