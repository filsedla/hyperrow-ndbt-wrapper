<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette\Database\IStructure;
use Nette\Object;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;

/**
 * Generates:
 *  model/generated/
 *  - GeneratedDatabase (fully generated, not editable, with table methods)
 *  - Database (extends GeneratedDatabase, generated once and empty, user editable)
 *
 */
class Generator extends Object
{

    /** @var string */
    protected $dir;

    /** @var string */
    protected $namespace;

    /** @var string */
    protected $rowBaseClass;

    /** @var string */
    protected $rowTableClass;

    /** @var string */
    protected $selectionBaseClass;

    /** @var string */
    protected $selectionTableClass;

    /** @var IStructure */
    protected $structure;

    /**
     * @param string $dir
     * @param string $namespace
     * @param string $rowBaseClass
     * @param string $rowTableClass
     * @param string $selectionBaseClass
     * @param string $selectionTableClass
     * @param IStructure $structure
     */
    public function __construct($dir, $namespace, $rowBaseClass, $rowTableClass, $selectionBaseClass, $selectionTableClass, IStructure $structure)
    {
        $this->dir = $dir;
        $this->namespace = $namespace;
        $this->rowBaseClass = $rowBaseClass;
        $this->rowTableClass = $rowTableClass;
        $this->selectionBaseClass = $selectionBaseClass;
        $this->selectionTableClass = $selectionTableClass;
        $this->structure = $structure;
    }


    /**
     * @return array
     */
    protected function getTables()
    {
        $tables = [];
        foreach ($this->structure->getTables() as $table) {
            if ($table['view'] === FALSE) {
                foreach ($this->structure->getColumns($table['name']) as $column) {
                    $tables[$table['name']][$column['name']] = \Nette\Database\Helpers::detectType($column['nativetype']);
                }
            }
        }
        return $tables;
    }


    /**
     * @return void
     */
    protected function generateGeneratedDatabase()
    {
        $className = 'GeneratedDatabase';
        $class = new ClassType($className);
        $class->setExtends('\Filsedla\Hyperrow\Database');

        foreach ($this->getTables() as $tableName => $columns) {

            $methodName = 'table' . Helpers::underscoreToCamel($tableName);

            $returnType = Helpers::underscoreToCamel($tableName) . 'HyperSelection';

            $class->addMethod($methodName)
                ->addBody('return $this->table(?);', [$tableName])
                ->addDocument("@return $returnType");
        }
        $code = implode("\n\n", [
            '<?php',
            "/**\n * This is a generated file. DO NOT EDIT. It will be overwritten.\n */",
            "namespace {$this->namespace};",
            $class
        ]);
        $file = $this->dir . '/' . $className . '.php';
        FileSystem::createDir($this->dir);
        FileSystem::write($file, $code, NULL);
    }


    /**
     * @return void
     */
    public function generate()
    {
        $this->generateGeneratedDatabase();
        $this->generateTables();
    }


    /**
     * @param string $namespace
     * @param string $className
     * @param string $extends
     * @param string $dir
     */
    protected function generateEmptyClass($namespace, $className, $extends, $dir)
    {
        $file = $dir . '/' . $className . '.php';
        if (is_file($file)) {
            return;
        }

        $class = new ClassType($className);
        $class->setExtends($extends);

        $code = implode("\n\n", [
            '<?php',
            "/**\n * This is a generated file. You CAN EDIT it, it was generated only once. It will not be overwritten.\n */",
            "namespace {$namespace};",
            $class
        ]);
        FileSystem::createDir($dir);
        FileSystem::write($file, $code, NULL);
    }


    /**
     * For each table generate:
     *  - "Table"GeneratedHyperSelection (fully generated)
     *  - "Table"HyperSelection (generated once, empty)
     *  - "Table"GeneratedHyperRow (fully generated)
     *  - "Table"HyperRow (generated once, empty)
     *
     * @return void
     */
    protected function generateTables()
    {
        foreach ($this->getTables() as $tableName => $columns) {

            $this->generateTableHyperSelection($tableName);
            $this->generateTableHyperRow($tableName);

            $this->generateTableGeneratedHyperSelection($tableName, $columns);
            $this->generateTableGeneratedHyperRow($tableName, $columns);
        }
    }

    /**
     * @param string $tableName
     * @return string
     */
    protected function getHyperRowTableClass($tableName)
    {
        return Strings::replace($this->rowTableClass, '#\*#', Helpers::underscoreToCamel($tableName), 1);
    }

    /**
     * @param string $tableName
     * @return string
     */
    protected function getHyperSelectionTableClass($tableName)
    {
        return Strings::replace($this->selectionTableClass, '#\*#', Helpers::underscoreToCamel($tableName), 1);
    }


    /**
     * @param string $tableName
     * @param array $columns
     * @return void
     */
    protected function generateTableGeneratedHyperSelection($tableName, $columns)
    {
        $className = Helpers::underscoreToCamel($tableName) . 'Generated' . 'HyperSelection';
        $dir = $this->dir . '/' . 'tables' . '/' . $tableName;

        $class = new ClassType($className);

        $class->setExtends($this->selectionBaseClass);

        // Add annotations for methods returning specific row class
        $methods = [
            'fetch' => $this->getHyperRowTableClass($tableName) . '|FALSE',
            'current' => $this->getHyperRowTableClass($tableName) . '|FALSE',
        ];

        foreach ($methods as $methodName => $returnType) {
            $class->addDocument("@method $returnType $methodName()");
        }

        $code = implode("\n\n", [
            '<?php',
            "/**\n * This is a generated file. DO NOT EDIT. It will be overwritten.\n */",
            "namespace {$this->namespace};",
            $class
        ]);
        $file = $dir . '/' . $className . '.php';
        FileSystem::createDir($this->dir);
        FileSystem::write($file, $code, NULL);
    }


    /**
     * @param string $tableName
     * @param array $columns
     * @return void
     */
    protected function generateTableGeneratedHyperRow($tableName, $columns)
    {
        $className = Helpers::underscoreToCamel($tableName) . 'Generated' . 'HyperRow';
        $dir = $this->dir . '/' . 'tables' . '/' . $tableName;

        $class = new ClassType($className);
        $class->setExtends($this->rowBaseClass);

        // Add property annotations based on columns
        foreach ($columns as $column => $type) {
            if ($type === IStructure::FIELD_DATETIME) {
                $type = '\Nette\Utils\DateTime';
            }
            $class->addDocument("@property-read $type \$$column");
        }

        // Generate 'ref' methods
        foreach ($this->structure->getBelongsToReference($tableName) as $referencingColumn => $referencedTable) {

            $methodName = 'referenced' . Helpers::underscoreToCamel($referencedTable);
            $returnType = $this->getHyperRowTableClass($referencedTable);

            $class->addMethod($methodName)
                ->addBody('return $this->ref(?, ?);', [$referencedTable, $referencingColumn])
                ->addDocument("@return $returnType");
        }

        // Generate 'related' methods
        foreach ($this->structure->getHasManyReference($tableName) as $relatedTable => $referencingColumns) {

            foreach ($referencingColumns as $referencingColumn) {

                if (count($referencingColumns) > 1) {
                    $methodName = 'related' . Helpers::underscoreToCamel($relatedTable) . 's'
                        . 'As' . Strings::firstUpper(Strings::replace($referencingColumn, '~_id$~'));
                } else {
                    $methodName = 'related' . Helpers::underscoreToCamel($relatedTable) . 's';
                }

                $returnType = $this->getHyperSelectionTableClass($relatedTable);

                $class->addMethod($methodName)
                    ->addBody('return $this->related(?, ?);', [$relatedTable, $referencingColumn])
                    ->addDocument("@return $returnType");
            }
        }

        $code = implode("\n\n", [
            '<?php',
            "/**\n * This is a generated file. DO NOT EDIT. It will be overwritten.\n */",
            "namespace {$this->namespace};",
            $class
        ]);
        $file = $dir . '/' . $className . '.php';
        FileSystem::createDir($this->dir);
        FileSystem::write($file, $code, NULL);
    }


    /**
     * @param string $tableName
     * @return void
     */
    protected function generateTableHyperSelection($tableName)
    {
        $className = Helpers::underscoreToCamel($tableName) . 'HyperSelection';
        $extends = Helpers::underscoreToCamel($tableName) . 'Generated' . 'HyperSelection';
        $dir = $this->dir . '/' . 'tables' . '/' . $tableName;

        $this->generateEmptyClass($this->namespace, $className, $extends, $dir);
    }


    /**
     * @param string $tableName
     */
    protected function generateTableHyperRow($tableName)
    {
        $className = Helpers::underscoreToCamel($tableName) . 'HyperRow';
        $extends = Helpers::underscoreToCamel($tableName) . 'Generated' . 'HyperRow';
        $dir = $this->dir . '/' . 'tables' . '/' . $tableName;

        $this->generateEmptyClass($this->namespace, $className, $extends, $dir);
    }

}