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

    /** @var Container */
    protected $container;


    /**
     * @param string $namespace
     * @param Container $container
     */
    public function __construct($namespace, Container $container)
    {
        $this->namespace = $namespace;
        $this->container = $container;
    }


    /**
     * @param Selection $selection
     * @return HyperSelection
     */
    public function create(Selection $selection)
    {
        $tableName = $selection->getName();

        $className = '\\' . $this->namespace . '\\' . Helpers::underscoreToCamel($tableName) . 'HyperSelection';
        $baseClass = HyperSelection::class;

        if (!class_exists($className) || !is_subclass_of($className, $baseClass))
            throw new InvalidStateException("HyperSelection class $className does not exist or does not extend $baseClass.");

        $names = $this->container->findByType($className);

        if (count($names) > 1) {
            throw new InvalidStateException("Multiple services of type $className found: " . implode(', ', $names) . '.');

        } elseif (count($names) == 0) {
            $inst = $this->container->createInstance($className);

        } else {
            $name = array_shift($names);
            $inst = $this->container->createService($name);
        }

        /** @var HyperSelection $inst */
        $inst->setHyperRowFactory($this->container->getByType(HyperRowFactory::class));
        $inst->setSelection($selection);

        return $inst;
    }

}