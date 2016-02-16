<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow\Model;

use Filsedla\Hyperrow\author_BaseRowClass;

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