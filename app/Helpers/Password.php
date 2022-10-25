<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\Hash;

class Password extends Hash {

    public static function generate()
    {
        $length = 12;
        $combination = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0"];
        $combination_count = count($combination);
        $password = "";

        for($i = 0; $i < $length ; $i++){
            $number  = rand(0, $combination_count);
            $password .= $combination[(int)$number];
        }

        return $password;
    }


}