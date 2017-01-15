<?php

/**
 * run Tester (Windows):
 * project root>vendor\bin\tester -s -c tests/php-win.ini tests
 */

if (@!include __DIR__ . '/../vendor/autoload.php') {
    echo 'Install Nette Tester using `composer install`';
    exit(1);
}

// configure environment
Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');

// create temporary directory
define('TEMP_DIR', __DIR__ . '/tmp');
@mkdir(TEMP_DIR); // @ - directory may already exist

// create $connection
$options = Tester\Environment::loadData() + ['user' => NULL, 'password' => NULL];

try {
    $connection = new Nette\Database\Connection($options['dsn'], $options['user'], $options['password']);
} catch (PDOException $e) {
    Tester\Environment::skip("Connection to '$options[dsn]' failed. Reason: " . $e->getMessage());
}

if (strpos($options['dsn'], 'sqlite::memory:') === FALSE) {
    Tester\Environment::lock($options['dsn'], TEMP_DIR);
}

// create $context
$cacheMemoryStorage = new Nette\Caching\Storages\MemoryStorage;
$structure = new Nette\Database\Structure($connection, $cacheMemoryStorage);
$conventions = new Nette\Database\Conventions\DiscoveredConventions($structure);
$context = new Nette\Database\Context($connection, $structure, $conventions, $cacheMemoryStorage);

$driverName = $connection->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);
Nette\Database\Helpers::loadFromFile($connection, __DIR__ . "/{$driverName}-test1.sql");
