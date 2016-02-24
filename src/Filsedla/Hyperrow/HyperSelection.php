<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Object;

/**
 *
 */
class HyperSelection extends Object implements \Iterator
{

    /** @var Selection */
    private $selection;

    /** @var HyperRowFactory */
    private $hyperRowFactory;


    /**
     * @param Selection $selection
     */
    public function setSelection(Selection $selection)
    {
        $this->selection = $selection;
    }


    /**
     * @param HyperRowFactory $hyperRowFactory
     */
    public function setHyperRowFactory(HyperRowFactory $hyperRowFactory)
    {
        $this->hyperRowFactory = $hyperRowFactory;
    }


    /**
     * @return HyperRow|FALSE
     */
    public function fetch()
    {
        $activeRow = $this->selection->fetch();
        if ($activeRow === FALSE) {
            return FALSE;
        }
        return $this->hyperRowFactory->create($activeRow, $this->selection->getName());
    }


    /**
     * Returns row specified by primary key.
     *
     * @param  mixed $key Primary key
     * @return HyperRow|FALSE
     */
    public function get($key)
    {
        $activeRow = $this->selection->get($key);
        if ($activeRow === FALSE) {
            return FALSE;
        }
        return $this->hyperRowFactory->create($activeRow, $this->selection->getName());
    }


    /**
     * Adds where condition, more calls appends with AND
     *
     * @param  string $condition condition possibly containing ?
     * @param  mixed $parameters ...
     * @return self
     */
    public function where($condition, $parameters = [])
    {
        call_user_func_array([$this->selection, 'where'], func_get_args());
        return $this;
    }


    /**
     * Counts number of rows
     *
     * @param  string $column if it is not provided returns count of result rows, otherwise runs new sql counting query
     * @return int
     */
    public function count($column = NULL)
    {
        return $this->selection->count($column);
    }


    /**
     * @return HyperRow|FALSE
     */
    public function current()
    {
        $activeRow = $this->selection->current();
        if ($activeRow === FALSE) {
            return FALSE;
        }
        return $this->hyperRowFactory->create($activeRow, $this->selection->getName());
    }


    /**
     * @return void
     */
    public function next()
    {
        $this->selection->next();
    }


    /**
     * @return string row ID
     */
    public function key()
    {
        return $this->selection->key();
    }


    /**
     * @return boolean
     */
    public function valid()
    {
        return $this->selection->valid();
    }


    /**
     * @return void
     */
    public function rewind()
    {
        $this->selection->rewind();
    }


    /**
     * Inserts row in a table
     *
     * @param  array|\Traversable|(Selection|self) $data array($column => $value)|\Traversable|(Selection|self) for INSERT ... SELECT
     * @return HyperRow|int|bool Returns HyperRow or number of affected rows for Selection or table without primary key
     */
    public function insert($data)
    {
        if ($data instanceof self) {
            $data = $data->selection;
        }

        $result = $this->selection->insert($data);

        if ($result instanceof ActiveRow) {
            return $this->hyperRowFactory->create($result, $this->selection->getName());
        }

        return $result;
    }


    /**
     * Updates all rows in result set.
     *
     * Joins in UPDATE are supported only in MySQL
     *
     * @param array|\Traversable $data ($column => $value)
     * @return int number of affected rows
     * @throws \Nette\InvalidArgumentException
     */
    public function update($data)
    {
        return $this->selection->update($data);
    }


    /**
     * Deletes all rows in result set.
     *
     * @return int number of affected rows
     */
    public function delete()
    {
        return $this->selection->delete();
    }

} 