<?php

namespace Kaitoj\Translator\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Session;
use Config;

class TranslationController extends Controller
{

    /**
     * Allow visitor to select language of the site and store preference in sesion setcookie
     * @var $request object Request
     * @var $lang  string
    */
    public  function change(Request $request, $lang) {

        session()->put('locale', $lang);
        session()->save();

        return redirect()->back();

    }

    public function index() {
      // Abort if not local environment
      if (!env('APP_ENV') == 'local') { abort(404);}

      dd('hello');
    }
}
