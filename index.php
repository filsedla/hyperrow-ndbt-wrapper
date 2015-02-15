<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass;

use Nette\Database\Context;

/** @var \Container_17980f83e2 $container */
$container = require __DIR__ . '/bootstrap.php';

///** @var Context $database */
//$database = $container->getByType('Nette\Database\Context');

/** @var Database $database */
$database = $container->getByType('Filsedla\CustomRowClass\Database');

// Use case selection->fetch
//dump($database->table('empty')->fetch());

// Use case selection foreach + row->related + row->toArray
//foreach ($database->table('author') as $author) {
//    /** @var ActiveRowWrapper $author */
//    dump($author->toArray());
//    foreach ($author->related('book') as $book) {
//        /** @var ActiveRowWrapper $book */
//        dump($book->toArray());
//    }
//}

//foreach ($database->table('book') as $book) {
//    /** @var ActiveRowWrapper $book */
//    /** @var ActiveRowWrapper $author */
//    dump($book->title);
//    dump($book->toArray());
//    $author = $book->author;
//    dump($author->name);
//    dump($author->toArray());
//}

// Use case selection->where
foreach ($database->table('author')->where('born = ? OR name LIKE ?', 1980, '%Vladimír%') as $author) {
    /** @var ActiveRowWrapper $author */
    dump($author->toArray());
}

