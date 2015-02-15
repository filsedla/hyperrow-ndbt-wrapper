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
class Database extends Object
{

    /** @var Context */
    private $context;

    /** @var ActiveRowWrapperFactory */
    private $activeRowWrapperFactory;


    function __construct(Context $context, ActiveRowWrapperFactory $activeRowWrapperFactory)
    {
        $this->context = $context;
        $this->activeRowWrapperFactory = $activeRowWrapperFactory;
    }


    /**
     * @param  string $table
     * @return SelectionWrapper
     */
    public function table($table)
    {
        $selection = $this->context->table($table);
        return new SelectionWrapper($selection, $this->activeRowWrapperFactory);
    }

} 