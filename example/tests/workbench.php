<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

/** @var SystemContainer $container */
$container = require __DIR__ . '/bootstrap.php';

/** @var \Example\Model\Database\Database $database */
$database = $container->getByType(\Example\Model\Database\Database::class);

//$result = $database->book->get(3)->relatedTaggings->getRelatedTags()->fetchAll();


$result = $database->author->page(1, 1);

foreach ($result as $key => $value) {
    dump([$key, $value]);
}


