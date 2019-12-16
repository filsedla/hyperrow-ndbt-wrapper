<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

/**
 * @property-read Selection $selection
 * @property-read Factory $factory
 */
class HyperSelection implements \Iterator, \ArrayAccess, \Countable
{

    /** @var Selection */
    private $selection;

    /** @var Factory */
    private $factory;


    /**
     * @return Selection
     */
    public function getSelection()
    {
        return $this->selection;
    }


    /**
     * @return Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }


    /**
     * @param Selection $selection
     */
    public function setSelection(Selection $selection)
    {
        $this->selection = $selection;
    }


    /**
     * @param Factory $factory
     */
    public function setFactory(Factory $factory)
    {
        $this->factory = $factory;
    }


    /**
     *
     */
    public function __clone()
    {
        $this->selection = clone $this->selection;
    }


    /**
     * Get corresponding table name
     *
     * @return string
     */
    public function getName()
    {
        return $this->selection->getName();
    }


    /**
     * @param  bool
     * @return string|array|NULL
     *
     * @throws \LogicException
     */
    public function getPrimary($need = TRUE)
    {
        return $this->selection->getPrimary($need);
    }


    /**
     * @return string
     */
    public function getSql()
    {
        return $this->selection->getSql();
    }


    /**
     * Fetches single row object.
     *
     * @return HyperRow|FALSE|NULL Returns false or null if there is no row
     */
    public function fetch()
    {
        $activeRow = $this->selection->fetch();
        if (!($activeRow instanceof ActiveRow)) {
            return $activeRow;
        }
        return $this->factory->createRow($activeRow, $this->selection->getName());
    }


    /**
     * Fetches single field.
     *
     * @param  string|NULL $column
     * @return mixed|FALSE|NULL
     */
    public function fetchField($column = NULL)
    {
        return $this->selection->fetchField($column);
    }


    /**
     * Fetches all rows as associative array.
     *
     * @param string $key column name used for an array key or NULL for numeric index
     * @param string $value column name used for an array value or NULL for the whole row
     *
     * @return array
     */
    public function fetchPairs($key = NULL, $value = NULL)
    {
        return $this->selection->fetchPairs($key, $value);
    }


    /**
     * Fetches all rows.
     *
     * @return HyperRow[]
     */
    public function fetchAll()
    {
        return iterator_to_array($this);
    }


    /**
     * Fetches all rows and returns associative tree.
     *
     * @param $path string associative descriptor
     * @return array
     */
    public function fetchAssoc($path)
    {
        return $this->selection->fetchAssoc($path);
    }


    /**
     * Returns row specified by primary key.
     *
     * @param  mixed $key Primary key
     * @return HyperRow|FALSE|NULL
     */
    public function get($key)
    {
        $result = $this->selection->get($key);

        if ($result instanceof ActiveRow) {
            return $this->factory->createRow($result, $this->selection->getName());
        }

        return $result;
    }


    /**
     * Adds select clause, more calls appends to the end.
     *
     * @param $columns string for example "column, MD5(column) AS column_md5"
     * @return self
     */
    public function select($columns)
    {
        call_user_func_array([$this->selection, 'select'], func_get_args());
        return $this;
    }


    /**
     * Adds condition for primary key.
     *
     * @param $key mixed
     * @return self
     */
    public function wherePrimary($key)
    {
        if (is_array($this->getPrimary(FALSE)) && Nette\Utils\Arrays::isList($key)) {

            if (isset($key[0]) && is_array($key[0])) {
                $this->where($this->getPrimary(), $key);

            } else {
                foreach ($this->getPrimary() as $i => $primary) {
                    $this->where($this->getName() . '.' . $primary, $key[$i]);
                }
            }
        } elseif (is_array($key) && !Nette\Utils\Arrays::isList($key)) { // key contains column names
            $this->where($key);

        } else {
            $this->where($this->getName() . '.' . $this->getPrimary(), $key);
        }

        return $this;
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
        $args = func_get_args();

        foreach ($args as $key => $value) {
            if ($value instanceof HyperSelection) {
                $args[$key] = $value->getSelection();
            }
        }

        call_user_func_array([$this->selection, 'where'], $args);
        return $this;
    }


    /**
     * Adds order clause, more calls appends to the end
     *
     * @param string $columns For example 'column1, column2 DESC'
     * @return self
     */
    public function order($columns)
    {
        call_user_func_array([$this->selection, 'order'], func_get_args());
        return $this;
    }


    /**
     * Sets limit clause, more calls rewrite old values
     *
     * @param int $limit
     * @param int $offset
     * @return self
     */
    public function limit($limit, $offset = NULL)
    {
        $this->selection->limit($limit, $offset);
        return $this;
    }


    /**
     * Sets offset using page number, more calls rewrite old values.
     * @param int $page
     * @param int $itemsPerPage
     * @param int $numOfPages
     *
     * @return self
     */
    public function page($page, $itemsPerPage, & $numOfPages = NULL)
    {
        if (func_num_args() > 2) {
            $this->selection->page($page, $itemsPerPage, $numOfPages);

        } else {
            $this->selection->page($page, $itemsPerPage);
        }

        return $this;
    }


    /**
     * Sets group clause, more calls rewrite old value.
     *
     * @param $columns string
     * @return self
     */
    public function group($columns)
    {
        call_user_func_array([$this->selection, 'group'], func_get_args());
        return $this;
    }


    /**
     * Sets having clause, more calls rewrite old value.
     *
     * @param $having string
     * @return self
     */
    public function having($having)
    {
        call_user_func_array([$this->selection, 'having'], func_get_args());
        return $this;
    }


    /**
     * Executes aggregation function.
     *
     * @param $function string select call in "FUNCTION(column)" format
     * @return string
     */
    public function aggregation($function)
    {
        return $this->selection->aggregation($function);
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
     * Returns minimum value from a column.
     *
     * @param $column string
     * @return int
     */
    public function min($column)
    {
        return $this->selection->min($column);
    }


    /**
     * Returns maximum value from a column.
     *
     * @param $column string
     * @return int
     */
    public function max($column)
    {
        return $this->selection->max($column);
    }


    /**
     * Returns sum of values in a column.
     *
     * @param $column string
     * @return int
     */
    public function sum($column)
    {
        return $this->selection->sum($column);
    }


    /**
     * @return HyperRow|FALSE
     */
    public function current()
    {
        $result = $this->selection->current();

        if ($result instanceof ActiveRow) {
            return $this->factory->createRow($result, $this->selection->getName());
        }

        return $result;
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
            return $this->factory->createRow($result, $this->selection->getName());
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
     * @throws Nette\InvalidArgumentException
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


    /**
     * Tests if row exists.
     *
     * @param mixed $key Row's primary key to check for.
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->selection->offsetExists($key);
    }


    /**
     * Returns specified row.
     *
     * @param mixed $key Row's primary key
     * @return HyperRow|NULL if there is no such row
     */
    public function offsetGet($key)
    {
        $result = $this->selection->offsetGet($key);

        if ($result instanceof ActiveRow) {
            return $this->factory->createRow($result, $this->selection->getName());
        }
        return $result;
    }


    /**
     * Mimic row.
     *
     * @param mixed $key Row's primary key
     * @param Nette\Database\Table\IRow $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->selection->offsetSet($key, $value);
    }


    /**
     * Removes row from result set.
     *
     * @param mixed $key Row's primary key to unset
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->selection->offsetUnset($key);
    }

}
