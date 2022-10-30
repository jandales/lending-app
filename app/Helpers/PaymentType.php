<?php 

namespace App\Helpers;



class PaymentType  {

    private static array $types = [
        'daily' => 1,
        'weekly' => 7,
        '15days' => 15,
        'monthly' => 30,
    ];


    public static function getValue($name)
    {   
       return self::$types[$name];
    }

    public static function getName($value)
    {
        return self::$types[$value];
    }


}