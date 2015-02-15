<?php
/**
 * Copyright (c) 2015 Filip Sedláček <filsedla@gmail.com>
 */

namespace Filsedla\CustomRowClass;

use Nette\Database\Context;
use Nette\Database\Helpers;
use Nette\Database\IStructure;
use Nette\Object;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\Strings;

/**
 *
 */
final class RowClassesBuilder extends Object
{

    /** @var Context */
    private $context;

    /** @var string */
    private $tempDir;

    /** @var array */
    private $config;

    /** @var ActiveRowWrapperFactory */
    private $activeRowWrapperFactory;


    /**
     * @param array $config
     * @param $tempDir
     * @param Context $context
     * @param ActiveRowWrapperFactory $activeRowWrapperFactory
     */
    function __construct(array $config, $tempDir, Context $context, ActiveRowWrapperFactory $activeRowWrapperFactory)
    {
        $this->config = $config;
        $this->tempDir = $tempDir;
        $this->context = $context;
        $this->activeRowWrapperFactory = $activeRowWrapperFactory;
    }


    public function build()
    {
        $tables = [];
        foreach ($this->context->getStructure()->getTables() as $table) {
            if ($table['view'] === FALSE) {
                foreach ($this->context->getStructure()->getColumns($table['name']) as $column) {
                    $tables[$table['name']][$column['name']] = Helpers::detectType($column['nativetype']);
                }
            }
        }

        // Create base row classes
        $classes = [];
        foreach ($tables as $table => $columns) {

            $className = $table . '_BaseRowClass';
            $class = new ClassType($className);
            $class->setExtends('\Filsedla\CustomRowClass\ActiveRowWrapper');

            foreach ($columns as $column => $type) {
                if ($type === IStructure::FIELD_DATETIME) {
                    $type = '\Nette\Utils\DateTime';
                }
                $class->addDocument("@property-read $type \$$column");
            }

            foreach ($this->context->getStructure()->getBelongsToReference($table) as $referencingColumn => $referencedTable) {
                $methodName = 'referenced' . Strings::firstUpper($referencedTable);
                $returnType = $this->activeRowWrapperFactory->tableNameToClassName($referencedTable);
                if (!Strings::startsWith($returnType, '\\')) {
                    $returnType = '\\' . $returnType;
                }
                $class->addMethod($methodName)
                    ->addBody('return $this->ref(?, ?);', [$referencedTable, $referencingColumn])
                    ->addDocument("@return $returnType");
            }

            foreach ($this->context->getStructure()->getHasManyReference($table) as $relatedTable => $referencingColumns) {
                foreach ($referencingColumns as $referencingColumn) {
                    $methodName = 'related' . Strings::firstUpper($relatedTable) . 's'
                        . (count($referencingColumns) > 1 ? 'As' . Strings::firstUpper(Strings::replace($referencingColumn, '~_id$~')) : '');
                    $returnType = '\Filsedla\CustomRowClass\SelectionWrapper'; //$this->activeRowWrapperFactory->tableNameToClassName($relatedTable);
//                    if (!Strings::startsWith($returnType, '\\')) {
//                        $returnType = '\\' . $returnType;
//                    }
                    $class->addMethod($methodName)
                        ->addBody('return $this->related(?, ?);', [$relatedTable, $referencingColumn])
                        ->addDocument("@return $returnType");
                }
            }

            $classes[] = $class;
        }
        $code = implode("\n\n", array_merge(['<?php', 'namespace Filsedla\CustomRowClass;'], $classes));
        file_put_contents($this->tempDir . DIRECTORY_SEPARATOR . "/row_classes_base_generated.php", $code);

        // Create database class
        $className = 'Systemdatabase';
        $class = new ClassType($className);
        $class->setExtends('\Filsedla\CustomRowClass\Database');
        foreach ($tables as $table => $columns) {
            $methodName = 'table' . Strings::firstUpper($table);
            $returnType = '\Filsedla\CustomRowClass\SelectionWrapper';
            $class->addMethod($methodName)
                ->addBody('return $this->table(?);', [$table])
                ->addDocument("@return $returnType");
        }
        $code = implode("\n\n", array_merge(['<?php', 'namespace Filsedla\CustomRowClass;'], [$class]));
        file_put_contents($this->tempDir . DIRECTORY_SEPARATOR . "/systemdatabase_generated.php", $code);
    }

} 