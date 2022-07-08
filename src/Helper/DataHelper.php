<?php

namespace Recruitment\Helper;

class DataHelper
{
    public static function prepareFloat(float $floatNumber): string
    {
        $vatStr = strval($floatNumber);
        if (intval($floatNumber) == $floatNumber) {
            $vatStr = strval(intval($floatNumber));
        }
        return $vatStr;
    }
}
