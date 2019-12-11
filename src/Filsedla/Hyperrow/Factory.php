<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\DI\Container;
use Nette\InvalidStateException;

/**
 *
 */
class Factory
{

    /** @var string */
    protected $selectionMapping;

    /** @var string */
    protected $rowMapping;

    /** @var Container */
    protected $container;


    /**
     * @param string $selectionMapping
     * @param string $rowMapping
     * @param Container $container
     */
    public function __construct($selectionMapping, $rowMapping, Container $container)
    {
        $this->selectionMapping = $selectionMapping;
        $this->rowMapping = $rowMapping;
        $this->container = $container;
    }


    /**
     * @param Selection $selection
     * @return HyperSelection
     */
    public function createSelection(Selection $selection)
    {
        $tableName = $selection->getName();
        $className = Helpers::substituteClassWildcard($this->selectionMapping, $tableName);

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
        $inst->setFactory($this);
        $inst->setSelection($selection);

        return $inst;
    }


    /**
     * @param ActiveRow $activeRow
     * @param $tableName
     * @throws InvalidStateException
     * @return HyperRow
     */
    public function createRow(ActiveRow $activeRow, $tableName)
    {
        $className = Helpers::substituteClassWildcard($this->rowMapping, $tableName);

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
        $inst->setFactory($this);
        $inst->setActiveRow($activeRow);

        return $inst;
    }

}
