<?php
namespace App\Helpers;

use NumberFormatter;

class Currency{
    public function __invoke($params)
    {
        return static::format(...$params);
    }
    public static function format($amount,$currency=null)
    {
       $formater= new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
       if($currency===null)
       {
        $currency=config('app.currency','USD');
       }
       return $formater->formatCurrency($amount,$currency);
    }
}