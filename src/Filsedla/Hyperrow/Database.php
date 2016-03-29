<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Context;
use Nette\Object;

/**
 *
 */
class Database extends Object
{

    /** @var Context */
    private $context;

    /** @var Factory */
    private $factory;


    /**
     * @param Context $context
     * @param Factory $factory
     */
    public function __construct(Context $context, Factory $factory)
    {
        $this->context = $context;
        $this->factory = $factory;
    }


    /**
     * @param string $tableName
     * @return HyperSelection
     */
    public function table($tableName)
    {
        $selection = $this->context->table($tableName);
        return $this->factory->createSelection($selection);
    }


    /**
     * @return void
     */
    public function beginTransaction()
    {
        $this->context->beginTransaction();
    }


    /**
     * @return void
     */
    public function commit()
    {
        $this->context->commit();
    }


    /**
     * @return void
     */
    public function rollBack()
    {
        $this->context->rollBack();
    }


    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

}
