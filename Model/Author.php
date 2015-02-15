<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass\Model;

use Filsedla\CustomRowClass\author_BaseRowClass;

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

} 