<?php
/**
 * Copyright (c) 2015 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass;

use Filsedla\CustomRowClass\Model\Book;
use Nette\Database\Context;


/** @var \Systemcontainer $container */
$container = require __DIR__ . '/bootstrap.php';

/** @var Context $database */
$context = $container->getByType('Nette\Database\Context');

// First automatically build base row classes
$builder = $container->getByType('Filsedla\CustomRowClass\RowClassesBuilder');
$builder->build();
require_once $container->parameters['tempDir'] . DIRECTORY_SEPARATOR . '/row_classes_base_generated.php';
require_once $container->parameters['tempDir'] . DIRECTORY_SEPARATOR . '/systemdatabase_generated.php';

$container->addService('Systemdatabase', $container->createInstance('Filsedla\CustomRowClass\Systemdatabase'));

/** @var Systemdatabase $database */
$database = $container->getService('Systemdatabase'); //$container->getByType('Filsedla\CustomRowClass\Systemdatabase');

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

//// Use case selection->where
//foreach ($database->table('author')->where('born = ? OR name LIKE ?', 1980, '%Vladimír%') as $author) {
//    /** @var ActiveRowWrapper $author */
//    dump($author->related('book')->fetch());
////    dump($author->related('book')->fetch()->related('tag')->fetch());
//}

// Use case: automatically generated base row classes
//foreach ($database->table('author') as $author) {
//    /** @var Author $author */
//    dump($author);
//    dump($author->name);
//    dump($author->related('book')->fetch());
//    dump($author->bookCount());
//    dump($author->related('book')->fetch());
//    dump($author->bookCount());
//}

// Use case: automatically generated base row classes
//foreach ($database->table('author') as $author) {
//    /** @var Author $author */
//    dump($author);
//    dump($author->relatedBooksAsTranslator());
//    foreach ($author->relatedBooksAsAuthor() as $book) {
//        dump($book);
//    }
//}

// Use case: automatically generated related/ref methods (TODO disable active row magic access OR add @properties to rows)
//foreach ($database->table('book') as $book) {
//    /** @var Book $book */
//    foreach ($book->relatedBook_tags() as $bookTag) {
//        /** @var book_tag_BaseRowClass $bookTag */
//        dump($bookTag->referencedTag()->name);
//    }
//}

// Use case: generated table methods
foreach ($database->tableBook() as $book) {
    /** @var Book $book */
    foreach ($book->relatedBook_tags() as $bookTag) {
        /** @var book_tag_BaseRowClass $bookTag */
        dump($bookTag->referencedTag()->name);
    }
}

dump($database->tableAuthor()->count());
dump($database->tableAuthor()->fetch());
