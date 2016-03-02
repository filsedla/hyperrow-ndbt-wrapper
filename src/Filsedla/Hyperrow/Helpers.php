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


    /**
     * @param string $fqn
     * @return null|string
     */
    public static function extractNamespace($fqn)
    {
        if (Strings::contains($fqn, '\\')) {
            return ltrim(substr($fqn, 0, strrpos($fqn, '\\')), '\\');
        }
        return NULL;
    }


    /**
     * @param string $fqn
     * @return null|string
     */
    public static function extractClassName($fqn)
    {
        if (Strings::contains($fqn, '\\')) {
            return substr($fqn, strrpos($fqn, '\\') + 1);
        }
        return ltrim($fqn, '\\');
    }


    /**
     * @param string $name String with * in it
     * @param string $substitution
     * @return string
     */
    public static function substituteClassWildcard($name, $substitution)
    {
        $substitution = self::underscoreToCamel($substitution);

        $substitution = Strings::firstUpper($substitution);
        return Strings::replace($name, '#\*#', $substitution);
    }


    /**
     * @param string $name String with * in it
     * @param string $substitution
     * @param string $suffix
     * @return string
     */
    public static function substituteMethodWildcard($name, $substitution, $suffix = '')
    {
        $substitution = self::underscoreToCamel($substitution);

        if (Strings::startsWith($name, '*')) {
            $substitution = Strings::firstLower($substitution);
        }

        // Plural
        if (Strings::contains($name, '*s')) {

            switch (Strings::substring($substitution, -1)) {
                case 's':
                    // nothing
                    break;
                case 'y':
                    $substitution = Strings::replace($substitution, '#y$#', 'ies');
                    break;
                default:
                    $substitution .= 's';
                    break;
            };

            return Strings::replace($name, '#\*s#', $substitution . $suffix);

        } else {
            return Strings::replace($name, '#\*#', $substitution . $suffix);
        }
    }

    /**
     * Returns properly formatted FQN with backslash at the beginning or class name if the provided $fqn
     * has the same namespace as $contextClassNamespace
     *
     * @param string $fqn
     * @param string $contextClassNamespace
     * @return string
     */
    public static function formatClassName($fqn, $contextClassNamespace)
    {
        $result = Helpers::extractClassName($fqn);
        $classNamespace = Helpers::extractNamespace($fqn);

        if ($classNamespace != $contextClassNamespace) {
            $result = $fqn;

            if (!Strings::startsWith($result, '\\')) {
                $result = '\\' . $result;
            }
        }

        return $result;
    }


}