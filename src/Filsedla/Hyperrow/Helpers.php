<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Object;
use Nette\Utils\Strings;

/**
 *
 */
class Helpers extends Object
{

    /**
     * @param string $string
     * @return string
     */
    public static function underscoreToCamel($string)
    {
        $words = Strings::split($string, '#_#');

        $result = '';
        foreach ($words as $word) {
            Strings::firstUpper($word);
            $result .= Strings::firstUpper($word);
        }
        return $result;
    }


}