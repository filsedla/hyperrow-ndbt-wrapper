<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

/** @var SystemContainer $container */
$container = require __DIR__ . '/bootstrap.php';

/** @var \Example\Model\Database\Database $database */
$database = $container->getByType(\Example\Model\Database\Database::class);

//$result = $database->book->get(3)->relatedTaggings->getRelatedTags()->fetchAll();

$result = $database->author->inBookAsAuthor(3);

foreach ($result as $row){
    dump($row->toArray());
}

