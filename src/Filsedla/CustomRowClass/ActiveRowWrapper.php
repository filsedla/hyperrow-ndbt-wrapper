<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass;

use Nette\Database\Table\ActiveRow;
use Nette\DeprecatedException;
use Nette\MemberAccessException;

/**
 *
 */
class ActiveRowWrapper implements \ArrayAccess
{

    /** @var ActiveRow */
    private $activeRow;


    function __construct(ActiveRow $activeRow)
    {
        $this->activeRow = $activeRow;
    }


    /**
     * Returns referencing rows
     *
     * @param string $key Other table name
     * @param string $throughColumn Other table column name
     * @return SelectionWrapper
     * @throws MemberAccessException
     */
    public function related($key, $throughColumn = NULL)
    {
        $groupedSelection = $this->activeRow->related($key, $throughColumn);
        return new SelectionWrapper($groupedSelection);
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return $this->activeRow->toArray();
    }


    /**
     * @param $key
     * @param $value
     * @throws DeprecatedException
     */
    public function __set($key, $value)
    {
        $this->activeRow->__set($key, $value);
    }


    /**
     * Returns value of column / referenced row
     *
     * @param $key
     * @return mixed|ActiveRowWrapper
     */
    public function &__get($key)
    {
        $result = $this->activeRow->__get($key);
        if ($result instanceof ActiveRow) {
            $activeRowWrapper = ActiveRowWrapperFactory::create($result, $result->getTable()->getName());
            return $activeRowWrapper;
        }
        return $result;
    }


    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->activeRow->__isset($key);
    }


    /**
     * @param $key
     * @throws DeprecatedException
     */
    public function __unset($key)
    {
        $this->activeRow->__unset($key);
    }


    /**
     * @param mixed $key
     * @param mixed $value
     * @throws DeprecatedException
     */
    public function offsetSet($key, $value)
    {
        $this->__set($key, $value);
    }


    /**
     * Returns value of column / referenced row
     *
     * @param string $key column name
     * @return mixed|ActiveRowWrapper
     * @throws MemberAccessException
     */
    public function offsetGet($key)
    {
        return $this->__get($key);
    }


    /**
     * Tests if column exists
     *
     * @param string $key column name
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->__isset($key);
    }


    /**
     * @param mixed $key
     * @throws DeprecatedException
     */
    public function offsetUnset($key)
    {
        $this->__unset($key);
    }

}