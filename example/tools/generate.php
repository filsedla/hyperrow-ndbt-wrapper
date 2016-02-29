<?php
/**
 * This script can be run either from web or from command line
 */

require __DIR__ . '/../vendor/autoload.php';

\Tracy\Debugger::enable();
\Tracy\Debugger::$strictMode = TRUE;
\Tracy\Debugger::$maxLen = 5000;
\Tracy\Debugger::$maxDepth = 6;

$robotLoader = new Nette\Loaders\RobotLoader;
$robotLoader->setCacheStorage(new \Nette\Caching\Storages\DevNullStorage())
    ->addDirectory(__DIR__ . '/../../src')// Hyperrow extension, unnecessary when installing through composer
    ->register();

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

$connection = new Nette\Database\Connection($config['database']['dsn'], $config['database']['user'], $config['database']['password']);
$structure = new Nette\Database\Structure($connection, new \Nette\Caching\Storages\DevNullStorage());
$generator = new \Filsedla\Hyperrow\Generator(
    $config['hyperrow'],
    $structure
);

$generator->generate();

if ($generator->isChanged()) {
    echo "Generation completed successfully. Hyperrow generated a few new things.\n";

} else {
    echo "Generation completed successfully. Nothing new has been generated.\n";
}


