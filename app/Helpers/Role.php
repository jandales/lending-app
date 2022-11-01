<?php

namespace App\Helpers;

class Role {

    public static $SUPERADMIN = 0;
    public static $ADMIN = 1;
    public static $EMPLOYEE = 1;


    public static function getName($role)
    {
        if (self::$SUPERADMIN == $role) return  'Super Admin';
        if (self::$admin === $role) return 'Admin';
        if (self::$EMPLOYEE === $role) return 'Employee';
    }
}