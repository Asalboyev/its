<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use App\Models\Lang;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public static $mainLanguage = 'ru'; //основной язык, который не должен отображаться в URl

    public static $languages = []; // Указываем, какие языки будем использовать в приложении.

    public static function getLocale()
    {
        $uri = Request::path(); //получаем URI

        self::$languages = array_merge(self::$languages, Lang::pluck('code')->toArray());

        $segmentsURI = explode('/',$uri); //делим на части по разделителю "/"

        //Проверяем метку языка  - есть ли она среди доступных языков
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], self::$languages)) {

            if ($segmentsURI[0] != self::$mainLanguage) return $segmentsURI[0];

        }

        return null;
    }

    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {
        $locale = self::getLocale();
        if($locale) \App::setLocale($locale);
        //если метки нет - устанавливаем основной язык $mainLanguage
        else \App::setLocale(self::$mainLanguage);

        return $next($request); //пропускаем дальше - передаем в следующий посредник
    }
}
