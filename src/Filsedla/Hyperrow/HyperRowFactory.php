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
class HyperRowFactory extends Object
{

    /** @var string */
    protected $namespace;

    /** @var string */
    protected $hyperRowClassName;

    /**
     * @param string $namespace
     * @param string $hyperRowClassName
     */
    public function __construct($namespace, $hyperRowClassName)
    {
        $this->namespace = $namespace;
        $this->hyperRowClassName = $hyperRowClassName;
    }


    /**
     * @param ActiveRow $activeRow
     * @param $tableName
     * @throws InvalidStateException
     */
    public function create(ActiveRow $activeRow, $tableName)
    {
        $className = '\\' . $this->namespace . '\\' . Helpers::underscoreToCamel($tableName) . $this->hyperRowClassName;
        $baseClass = BaseHyperRow::class;

        if (!class_exists($className) || !is_subclass_of($className, $baseClass))
            throw new InvalidStateException("HyperRow class $className does not exist or does not extend $baseClass.");

        return new $className($activeRow, $this);

    }


}