<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass\Model;

use Filsedla\CustomRowClass\author_BaseRowClass;
use Filsedla\CustomRowClass\SelectionWrapper;

/**
 *
 */
final class Author extends author_BaseRowClass
{

    /**
     * @return int
     */
    public function bookCount()
    {
        return $this->related('book')->count();
    }


    /**
     * @return SelectionWrapper
     */
    public function relatedBooks()
    {
        return $this->related('book');
    }

} 