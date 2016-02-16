<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Table\ActiveRow;
use Nette\InvalidStateException;
use Nette\Object;

/**
 *
 */
class ActiveRowWrapperFactory extends Object
{

    /** @var array */
    private $config;


    function __construct(array $config)
    {
        $this->config = $config;
    }


    /**
     * @param ActiveRow $activeRow
     * @param $tableName
     * @throws InvalidStateException
     */
    public function create(ActiveRow $activeRow, $tableName)
    {
        $className = $this->tableNameToClassName($tableName);
        $wrapperBaseClass = 'Filsedla\Hyperrow\ActiveRowWrapper';

        if (!class_exists($className) || !is_subclass_of($className, $wrapperBaseClass))
            throw new InvalidStateException("ActiveRow wrapper class $className does not exist or does not extend $wrapperBaseClass.");

        return new $className($activeRow, $this);

    }


    /**
     * @param string $tableName
     * @return string
     */
    public function tableNameToClassName($tableName)
    {
        if (array_key_exists($tableName, $this->config)) {
            return $this->config[$tableName];
        }
        return '\Filsedla\Hyperrow' . '\\' . $tableName . '_BaseRowClass';
    }

} 