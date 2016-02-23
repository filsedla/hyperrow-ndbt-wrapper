<?php
/**
 * This script can be run either from web or from command line
 */

require __DIR__ . '/../vendor/autoload.php';

\Tracy\Debugger::enable();

$loader = new Nette\Loaders\RobotLoader;
$loader->setCacheStorage(new \Nette\Caching\Storages\DevNullStorage());
$loader->addDirectory(__DIR__)
    ->addDirectory(__DIR__ . '/../../src')// Databoot extension, unnecessary when installing through composer
    ->register();

$neonFile = __DIR__ . '/../app/config/config.local.neon';
$neon = new \Nette\DI\Config\Adapters\NeonAdapter();
$config = $neon->load($neonFile);

$config = array_merge($config, [
    'dir' => __DIR__ . '/../app/model/database/generated',
    'namespace' => 'Example\Model\Database',
    'classes' => [
        'row' => [
            'base' => 'BaseHyperRow',
            'table' => '*HyperRow',
        ],
        'selection' => [
            'base' => 'BaseHyperSelection',
            'table' => '*HyperSelection',
        ]
    ]
]);

$connection = new Nette\Database\Connection($config['database']['dsn'], $config['database']['user'], $config['database']['password']);
$structure = new Nette\Database\Structure($connection, new \Nette\Caching\Storages\DevNullStorage());
$generator = new \Filsedla\Hyperrow\Generator(
    $config['dir'],
    $config['namespace'],
    $config['classes']['row']['base'],
    $config['classes']['row']['table'],
    $config['classes']['selection']['base'],
    $config['classes']['selection']['table'],
    $structure
);

$generator->generate();

echo "OK\n";
