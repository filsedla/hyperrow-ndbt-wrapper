<?php
/**
 * This script can be run either from web or from command line
 */

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../app/shortcuts.php';

\Tracy\Debugger::enable();
\Tracy\Debugger::$strictMode = TRUE;
\Tracy\Debugger::$maxLen = 5000;
\Tracy\Debugger::$maxDepth = 6;

// Configure robot loader without cache (no optimization is needed here)
$robotLoader = new Nette\Loaders\RobotLoader;
$robotLoader->setCacheStorage(new \Nette\Caching\Storages\DevNullStorage());

// Index Hyperrow, unnecessary when Hyperrow is installed through composer
$robotLoader->addDirectory(__DIR__ . '/../../src');

// Index model classes, useful for excluding already existing classes from generation
$robotLoader->addDirectory(__DIR__ . '/../app/model/database');

$robotLoader->register();

// Manually prepare and load config files: Hyperrow defaults + application configs
$configFiles = [
    __DIR__ . '/../../src/Filsedla/Hyperrow/defaults.neon', // Adjust path when installing through composer
    __DIR__ . '/../app/config/config.neon',
    __DIR__ . '/../app/config/config.local.neon',
];
$configLoader = new \Nette\DI\Config\Loader();
$config = [];
foreach ($configFiles as $file) {
    $config = \Nette\DI\Config\Helpers::merge($configLoader->load($file), $config);
}
$config['hyperrow']['dir'] = str_replace('%appDir%', __DIR__ . '/../app', $config['hyperrow']['dir']);
//dump($config); exit;

// Create a few necessary services
$connection = new Nette\Database\Connection($config['database']['dsn'], $config['database']['user'], $config['database']['password']);
$structure = new Nette\Database\Structure($connection, new \Nette\Caching\Storages\DevNullStorage());
$generator = new \Filsedla\Hyperrow\Generator(
    $config['hyperrow'],
    $structure
);

// Tell generator which classes were already found by Robot loader to not generate them again
// (generator cannot use class_exists() because those classes may be unloadable due to extending a class yet to be generated)
$generator->setExcludedClasses(array_keys($robotLoader->getIndexedClasses()));

$generator->generate();

if ($generator->isChanged()) {
    echo "Generation completed successfully. Hyperrow generated a few new things.\n";

} else {
    echo "Generation completed successfully. Nothing new has been generated.\n";
}


