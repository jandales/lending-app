<?php

namespace App\Enums;


enum Role: int 
{
    case SuperAdmin = 0;
    case Admin = 1;
    case Employee = 2;
}

?>

