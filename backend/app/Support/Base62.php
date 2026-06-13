<?php

namespace App\Support;

class Base62
{
    protected const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function encode(int $number): string
    {
        if ($number === 0) {
            return '0';
        }

        $result = '';

        while ($number > 0) {
            $result = self::CHARS[$number % 62] . $result;
            $number = intdiv($number, 62);
        }

        return $result;
    }
}
