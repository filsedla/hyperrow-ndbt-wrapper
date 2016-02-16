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

    /** @var HyperSelectionFactory */
    private $hyperSelectionFactory;


    /**
     * @param Context $context
     * @param HyperSelectionFactory $hyperSelectionFactory
     */
    public function __construct(Context $context, HyperSelectionFactory $hyperSelectionFactory)
    {
        $this->context = $context;
        $this->hyperSelectionFactory = $hyperSelectionFactory;
    }


    /**
     * @param  string $tableName
     * @return BaseHyperSelection
     */
    public function table($tableName)
    {
        $selection = $this->context->table($tableName);
        $hyperSelection = $this->hyperSelectionFactory->create($selection);
        return $hyperSelection;
    }

} 