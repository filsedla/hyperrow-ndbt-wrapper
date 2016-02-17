<?php
/**
 * Copyright (c) 2016 Filip Sedláček <filsedla@gmail.com>
 */

namespace Example\Model;

use Nette\Object;
use Nette\Utils\Strings;

/**
 *
 */
class DummyProcessingService extends Object
{

    /**
     * @param $string
     * @return string
     */
    public function process($string)
    {
        return Strings::lower($string);
    }

}