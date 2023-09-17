<?php

namespace App\Enum;

trait EnumSerializer
{

    /**
     * it converts enum to associative array to be used with the select input
     * so the case value become the key and the case name will be converted to words separated by space and used as value
     */
    public static function toArrayForSelectInput(): array
    {
        $cases = self::cases();
        $arr = [];
        foreach ($cases as $case) {
            $arr[$case->value] =  preg_replace('/([a-z])([A-Z])/', '$1 $2', $case->name);
        }
        return $arr;
    }
}
