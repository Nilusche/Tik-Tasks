<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
class LanguageController extends Controller
{
    public function switch_language($language){
        session(['locale' => $language]);
        App::setLocale($language);
        Carbon::setLocale($language);
        return redirect()->back();
    }
}
