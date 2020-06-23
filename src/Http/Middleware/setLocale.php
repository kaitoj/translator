<?php

namespace Kaitoj\Translator\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class SetLocale
{
    public $supported = [
        'en' => 'en_GB',
        'ja' => 'ja',
        'en-GB' => 'en_GB',
        'en-US' => 'en_GB',
        'es' => 'es_ES',

    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if ($request->is('language/*')) {return $next($request);}

        if (Session::has('locale')) {
            $locale = Session::get('locale', Config::get('app.locale'));
        } else {
            $code = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            
            if (!array_key_exists($code, $this->supported)) {
                $locale = 'en_GB';
            } else {
                
                $locale = $this->supported[$code];
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}
