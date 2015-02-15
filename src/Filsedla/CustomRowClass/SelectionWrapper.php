<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass;

use Nette\Database\Table\Selection;
use Nette\Object;

/**
 *
 */
class SelectionWrapper extends Object implements \Iterator
{

    /** @var Selection */
    private $selection;


    function __construct(Selection $selection)
    {
        $this->selection = $selection;
    }


    /**
     * @return ActiveRowWrapper|FALSE
     */
    public function fetch()
    {
        $activeRow = $this->selection->fetch();
        if ($activeRow === FALSE) {
            return FALSE;
        }
        return ActiveRowWrapperFactory::create($activeRow, $this->selection->getName());
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
     * @return ActiveRowWrapper|FALSE
     */
    public function current()
    {
        $activeRow = $this->selection->current();
        if ($activeRow === FALSE) {
            return FALSE;
        }
        return ActiveRowWrapperFactory::create($activeRow, $this->selection->getName());
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


} 