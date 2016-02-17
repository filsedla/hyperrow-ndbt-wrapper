<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Table\Selection;
use Nette\DI\Container;
use Nette\InvalidStateException;
use Nette\Object;

/**
 *
 */
class HyperSelectionFactory extends Object
{
    /** @var string */
    protected $namespace;

    /** @var string */
    protected $hyperSelectionClassName;

    /** @var Container */
    protected $container;

    /**
     * @param string $namespace
     * @param string $hyperSelectionClassName
     * @param Container $container
     */
    public function __construct($namespace, $hyperSelectionClassName, Container $container)
    {
        $this->namespace = $namespace;
        $this->hyperSelectionClassName = $hyperSelectionClassName;
        $this->container = $container;
    }


    /**
     * @param Selection $selection
     * @return HyperSelection
     */
    public function create(Selection $selection)
    {
        $tableName = $selection->getName();

        $className = '\\' . $this->namespace . '\\' . Helpers::underscoreToCamel($tableName) . $this->hyperSelectionClassName;
        $baseClass = HyperSelection::class;

        if (!class_exists($className) || !is_subclass_of($className, $baseClass))
            throw new InvalidStateException("HyperSelection class $className does not exist or does not extend $baseClass.");

        return $this->container->createInstance($className, [$selection]);
    }

}