<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass;

use Nette\Database\Table\ActiveRow;
use Nette\InvalidStateException;
use Nette\Object;

/**
 *
 */
class ActiveRowWrapperFactory extends Object
{

    /**
     * @param ActiveRow $activeRow
     * @param $table
     * @throws InvalidStateException
     */
    public static function create(ActiveRow $activeRow, $table)
    {
        $table = 'Filsedla\CustomRowClass' . '\\' . $table . '_BaseRowClass';
        $wrapperBaseClass = 'Filsedla\CustomRowClass\ActiveRowWrapper';

        if (!class_exists($table) || !is_subclass_of($table, $wrapperBaseClass))
            throw new InvalidStateException("ActiveRow wrapper class $table does not exist or does not extend $wrapperBaseClass.");

        return new $table($activeRow);

    }

} 