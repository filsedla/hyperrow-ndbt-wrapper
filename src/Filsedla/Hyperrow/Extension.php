<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette;

/**
 *
 */
final class Extension extends Nette\DI\CompilerExtension
{

    /** @var array */
    public $defaults = [
        'dir' => '%appDir%/model/database/generated',
        'namespace' => 'Model\Database',
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
    ];


    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);

        $builder = $this->getContainerBuilder();

        // - Filsedla\Hyperrow\HyperSelectionFactory(%hyperrow.namespace%)
        $builder->addDefinition($this->prefix('hyperSelectionFactory'))
            ->setClass(HyperSelectionFactory::class, [$config['namespace']]);

        // - Filsedla\Hyperrow\HyperRowFactory(%hyperrow.namespace%, ...)
        $builder->addDefinition($this->prefix('hyperRowFactory'))
            ->setClass(HyperRowFactory::class, [$config['namespace']]);

        /*
            - Filsedla\Hyperrow\Generator(
            %hyperrow.dir%,
            %hyperrow.namespace%,
            %hyperrow.classes.row.base%,
            %hyperrow.classes.row.table%,
            %hyperrow.classes.selection.base%,
            %hyperrow.classes.selection.table%,
            ...)
        */
        $builder->addDefinition($this->prefix('generator'))
            ->setClass(Generator::class, [
                $config['dir'],
                $config['namespace'],
                $config['classes']['row']['base'],
                $config['classes']['row']['table'],
                $config['classes']['selection']['base'],
                $config['classes']['selection']['table'],
            ])
            ->setAutowired(FALSE);
    }
}