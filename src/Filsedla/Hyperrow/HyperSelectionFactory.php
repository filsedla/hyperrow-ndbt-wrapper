<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Table\Selection;
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

    /** @var HyperRowFactory */
    protected $hyperRowFactory;


    /**
     * @param string $namespace
     * @param string $hyperSelectionClassName
     * @param HyperRowFactory $hyperRowFactory
     */
    public function __construct($namespace, $hyperSelectionClassName, HyperRowFactory $hyperRowFactory)
    {
        $this->namespace = $namespace;
        $this->hyperSelectionClassName = $hyperSelectionClassName;
        $this->hyperRowFactory = $hyperRowFactory;
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

        return new $className($selection, $this->hyperRowFactory);
    }

}