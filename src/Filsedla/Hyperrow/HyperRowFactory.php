<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
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

        $names = $this->container->findByType($className);

        if (count($names) > 1) {
            throw new InvalidStateException("Multiple services of type $className found: " . implode(', ', $names) . '.');

        } elseif (count($names) == 0) {
            $inst = $this->container->createInstance($className);

        } else {
            $name = array_shift($names);
            $inst = $this->container->createService($name);
        }

        /** @var HyperRow $inst */
        $inst->setHyperRowFactory($this->container->getByType(HyperRowFactory::class));
        $inst->setHyperSelectionFactory($this->container->getByType(HyperSelectionFactory::class));
        $inst->setActiveRow($activeRow);

        return $inst;
    }


}