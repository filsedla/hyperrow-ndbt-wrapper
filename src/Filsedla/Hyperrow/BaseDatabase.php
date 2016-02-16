<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\Context;
use Nette\Object;

/**
 *
 */
class BaseDatabase extends Object
{

    /** @var Context */
    private $context;

    /** @var HyperRowFactory */
    private $hyperRowFactory;


    function __construct(Context $context, HyperRowFactory $hyperRowFactory)
    {
        $this->context = $context;
        $this->hyperRowFactory = $hyperRowFactory;
    }


    /**
     * @param  string $table
     * @return BaseHyperSelection
     */
    public function table($table)
    {
        $selection = $this->context->table($table);
        return new BaseHyperSelection($selection, $this->hyperRowFactory);
    }

} 