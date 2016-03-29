<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Object;

/**
 * @property-read Selection $selection
 * @property-read Factory $factory
 */
class HyperSelection extends Object implements \Iterator
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
     * Fetches single row object.
     *
     * @return HyperRow|FALSE FALSE if there is no row
     */
    public function fetch()
    {
        $activeRow = $this->selection->fetch();
        if ($activeRow === FALSE) {
            return FALSE;
        }
        return $this->factory->createRow($activeRow, $this->selection->getName());
    }


    /**
     * Fetches single field.
     *
     * @param  string|NULL $column
     * @return mixed|FALSE
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
        return $this->factory->createRow($activeRow, $this->selection->getName());
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
        return $this->factory->createRow($activeRow, $this->selection->getName());
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