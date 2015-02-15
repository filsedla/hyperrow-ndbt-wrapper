<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass;

use Nette\Database\Context;

/** @var \Container_17980f83e2 $container */
$container = require __DIR__ . '/bootstrap.php';

/** @var Context $database */
$database = $container->getByType('Nette\Database\Context');

dump($database);