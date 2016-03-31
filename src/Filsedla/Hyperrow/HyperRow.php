<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Table\ActiveRow;
use Nette\DeprecatedException;
use Nette\MemberAccessException;
use Nette\Utils\ObjectMixin;

/**
 * @property-read ActiveRow $activeRow
 * @property-read Factory $factory
 */
class HyperRow implements \ArrayAccess, \IteratorAggregate
{

    /** @var ActiveRow */
    private $activeRow;

    /** @var Factory */
    private $factory;


    /**
     * @return ActiveRow
     */
    public function getActiveRow()
    {
        return $this->activeRow;
    }


    /**
     * @return Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }


    /**
     * @param ActiveRow $activeRow
     */
    public function setActiveRow(ActiveRow $activeRow)
    {
        $this->activeRow = $activeRow;
    }

    /**
     * @param Factory $factory
     */
    public function setFactory(Factory $factory)
    {
        $this->factory = $factory;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return (string)call_user_func_array([$this->activeRow, '__toString'], func_get_args());
    }


    /**
     * Returns primary key value.
     *
     * @param $need bool
     * @return mixed possible int, string, array, object (Nette\Utils\DateTime)
     */
    public function getPrimary($need = TRUE)
    {
        return $this->activeRow->getPrimary($need);
    }


    /**
     * Returns referencing rows
     *
     * @param string $key Other table name
     * @param string $throughColumn Other table column name
     * @return HyperSelection
     * @throws MemberAccessException
     */
    public function related($key, $throughColumn = NULL)
    {
        $groupedSelection = $this->activeRow->related($key, $throughColumn);
        return $this->factory->createSelection($groupedSelection);
    }


    /**
     * Returns referenced row
     *
     * @param string $key
     * @param string $throughColumn
     * @return self|NULL if the row does not exist
     * @throws MemberAccessException if the relationship does not exist
     */
    public function ref($key, $throughColumn = NULL)
    {
        $result = $this->activeRow->ref($key, $throughColumn);
        if ($result instanceof ActiveRow) {
            $hyperrow = $this->factory->createRow($result, $result->getTable()->getName());
            return $hyperrow;
        }
        return NULL;
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
     * @return mixed|HyperRow|HyperSelection
     */
    public function &__get($key)
    {
        // Try to get method - getter
        if (ObjectMixin::has($this, $key)) {
            return ObjectMixin::get($this, $key);
        }

        // Otherwise get ActiveRow property
        $result = $this->activeRow->__get($key);

        if ($result instanceof ActiveRow) {
            $hyperrow = $this->factory->createRow($result, $result->getTable()->getName());
            return $hyperrow;
        }

        return $result;
    }


    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return ObjectMixin::has($this, $key) || $this->activeRow->__isset($key);
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
     * @return mixed|HyperRow
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


    /**
     * Updates row.
     *
     * @param  array|\Traversable $data (column => value)
     * @return bool
     */
    public function update($data)
    {
        return $this->activeRow->update($data);
    }


    /**
     * Deletes row.
     *
     * @return int number of affected rows
     */
    public function delete()
    {
        return $this->activeRow->delete();
    }


    /**
     * Retrieve an external iterator
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->activeRow->getIterator();
    }
}