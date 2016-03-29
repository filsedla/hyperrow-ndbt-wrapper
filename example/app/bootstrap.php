<?php

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/shortcuts.php';

\Tracy\Debugger::$maxLen = 5000;
\Tracy\Debugger::$maxDepth = 6;

$configurator = new Nette\Configurator;
//$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$loader = $configurator->createRobotLoader();
$loader->addDirectory(__DIR__)
    ->addDirectory(__DIR__ . '/../../src')
    ->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

// Generator can be run either this way (disadvantage: more errors from not-yet-existing classes)
// or separately (tools/generate.php)
if ($container->parameters['debugMode'] === TRUE) {

    /** @var \Nette\Database\IStructure $structure */
    $structure = $container->getByType(\Nette\Database\IStructure::class);
    $structure->rebuild();

    $generator = $container->createService('hyperrow.generator');

    // Tell generator which classes were already found by Robot loader to not generate them again
    // (generator cannot use class_exists() because those classes may be unloadable due to extending a class yet to be generated)
    $generator->setExcludedClasses(array_keys($loader->getIndexedClasses()));

    $generator->generate();

    if ($generator->isChanged()) {
        $loader->rebuild();
        echo "Hyperrow just generated a few classes. Please refresh the page.\n";
        exit;
    }
}

return $container;
