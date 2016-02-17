<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Table\ActiveRow;
use Nette\DI\Container;
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

    /** @var Container */
    protected $container;


    /**
     * @param string $namespace
     * @param string $hyperRowClassName
     * @param Container $container
     */
    public function __construct($namespace, $hyperRowClassName, Container $container)
    {
        $this->namespace = $namespace;
        $this->hyperRowClassName = $hyperRowClassName;
        $this->container = $container;
    }


    /**
     * @param ActiveRow $activeRow
     * @param $tableName
     * @throws InvalidStateException
     * @return HyperRow
     */
    public function create(ActiveRow $activeRow, $tableName)
    {
        $className = '\\' . $this->namespace . '\\' . Helpers::underscoreToCamel($tableName) . $this->hyperRowClassName;
        $baseClass = HyperRow::class;

        if (!class_exists($className) || !is_subclass_of($className, $baseClass))
            throw new InvalidStateException("HyperRow class $className does not exist or does not extend $baseClass.");

        return $this->container->createInstance($className, [$activeRow]);
    }


}