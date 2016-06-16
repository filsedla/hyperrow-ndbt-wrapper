<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

/** @var SystemContainer $container */
$container = require __DIR__ . '/bootstrap.php';

/** @var \Example\Model\Database\Database $database */
$database = $container->getByType(\Example\Model\Database\Database::class);

$row = $database->transaction(function() use ($database){
    $row = $database->empty->insert([
        'name' => 'a',
    ]);
    echo $database->empty->count() . "<br>";

//    try {

        $innerRow = $database->transaction(function () use ($database) {
            $row = $database->empty->insert([
                'name' => 'b',
            ]);
            echo $database->empty->count() . "<br>";

            throw new \PDOException("inner exception");

            return $row;
        });
//    }catch (\Exception $e){}

    //throw new \PDOException("outer exception");

    echo $database->empty->count() . "<br>";

    return $row;
});

dd($row);

exit;

$database->beginTransaction();

$database->empty->insert([
    'name' => 'a',
]);
echo $database->empty->count() . "<br>";

// --v

$database->beginTransaction();

$database->empty->insert([
    'name' => 'b',
]);

echo $database->empty->count() . "<br>";

$database->commit();

// --^

echo $database->empty->count() . "<br>";

//$database->rollBack();

echo $database->empty->count() . "<br>";

