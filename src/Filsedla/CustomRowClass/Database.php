<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass;

use Nette\Database\Context;
use Nette\Object;

/**
 *
 */
final class Database extends Object
{

    /** @var Context */
    private $context;


    function __construct(Context $context)
    {
        $this->context = $context;
    }


    /**
     * @param  string $table
     * @return SelectionWrapper
     */
    public function table($table)
    {
        $selection = $this->context->table($table);
        return new SelectionWrapper($selection);
    }

} 