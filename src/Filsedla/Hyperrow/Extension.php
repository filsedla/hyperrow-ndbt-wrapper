<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette;
use Nette\Utils\Validators;

/**
 *
 */
final class Extension extends Nette\DI\CompilerExtension
{

    /** @var array Defaults loaded from NEON file */
    protected $defaults;


    public function loadConfiguration()
    {
        $this->defaults = Nette\Neon\Neon::decode(file_get_contents(__DIR__ . '/defaults.neon'))['hyperrow'];
        $config = $this->getConfig($this->defaults);

        Validators::assertField($config, 'nestedTransactions', 'bool');

        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('config'))
            ->setClass(Config::class, [$config]);

        $builder->addDefinition($this->prefix('factory'))
            ->setClass(Factory::class, [
                $config['classes']['selection']['mapping'],
                $config['classes']['row']['mapping'],
            ]);

        $builder->addDefinition($this->prefix('generator'))
            ->setClass(Generator::class, [$config])
            ->setAutowired(FALSE);
    }
}