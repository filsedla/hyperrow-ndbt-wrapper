<?php
/**
 * Copyright (c) 2016 Filip Sedlacek <filsedla@gmail.com>
 */

namespace Filsedla\Hyperrow;

use Nette;
use Nette\Database\IStructure;
use Nette\Object;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;

/**
 *
 */
class Generator extends Object
{
    /** @var IStructure */
    protected $structure;

    /** @var array */
    protected $config;

    /** @var bool */
    protected $changed = FALSE;

    /** @var array Array of FQNs to exclude from generation - currently applies only to classes that are generated empty */
    protected $excludedClasses = [];


    /**
     * @param array $config
     * @param IStructure $structure
     */
    public function __construct(array $config, IStructure $structure)
    {
        $this->config = $config;
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
     * @return boolean
     */
    public function isChanged()
    {
        return $this->changed;
    }


    /**
     * @return array
     */
    public function getExcludedClasses()
    {
        return $this->excludedClasses;
    }


    /**
     * @param array $excludedClasses
     */
    public function setExcludedClasses(array $excludedClasses)
    {
        $this->excludedClasses = $excludedClasses;
    }

    /**
     * @return void
     */
    protected function generateGeneratedDatabase()
    {
        $classFqn = $this->config['classes']['database']['generated'];
        $className = Helpers::extractClassName($classFqn);
        $classNamespace = Helpers::extractNamespace($classFqn);

        $class = new ClassType($className);
        $class->setExtends('\Filsedla\Hyperrow\Database');

        // Generate methods.database.table
        foreach ((array)$this->config['methods']['database']['table'] as $methodTemplate) {

            foreach ($this->getTables() as $tableName => $columns) {

                if (is_array($this->config['tables']) && !in_array($tableName, $this->config['tables'])) {
                    continue;
                }

                $methodName = Helpers::substituteMethodWildcard($methodTemplate, $tableName);
                $returnType = $this->getTableClass('selection', $tableName, $classNamespace);

                $class->addMethod($methodName)
                    ->addBody('return $this->table(?);', [$tableName])
                    ->addDocument("@return $returnType");

                if ($methodTemplate == 'get*') {

                    // Add property annotations
                    $property = Strings::firstLower(Helpers::underscoreToCamel($tableName));
                    $correspondingHyperSelectionTableClass = $this->getTableClass('selection', $tableName, $classNamespace);
                    $class->addDocument("@property-read $correspondingHyperSelectionTableClass \$$property");
                }
            }
        }

        $code = implode("\n\n", [
            '<?php',
            "/**\n * This is a generated file. DO NOT EDIT. It will be overwritten.\n */",
            "namespace {$classNamespace};",
            $class
        ]);
        $file = $this->config['dir'] . '/' . $className . '.php';

        $this->writeIfChanged($file, $code);
    }

    /**
     * @param string $file
     * @param string $code
     */
    protected function writeIfChanged($file, $code)
    {
        $content = @file_get_contents($file); // @ file may not exist
        if (!$content || $content != $code) {
            FileSystem::createDir(dirname($file));
            FileSystem::write($file, $code, NULL);
            $this->changed = TRUE;
        }
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
        $classFqn = $namespace . '\\' . $className;

        if (in_array($classFqn, $this->excludedClasses)) {
            return;
        }

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

        $this->writeIfChanged($file, $code);
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

            if (is_array($this->config['tables']) && !in_array($tableName, $this->config['tables'])) {
                continue;
            }

            $this->generateTableClass('selection', $tableName);
            $this->generateTableClass('row', $tableName);

            $this->generateTableGeneratedHyperSelection($tableName, $columns);
            $this->generateTableGeneratedHyperRow($tableName, $columns);
        }
    }


    /**
     * @param string $type selection|row
     * @param string $tableName
     * @param string $contextClassNamespace
     * @return string
     */
    protected function getTableClass($type, $tableName, $contextClassNamespace)
    {
        $classFqn = $this->config['classes'][$type]['*'];
        $classFqn = Helpers::substituteClassWildcard($classFqn, $tableName);

        return Helpers::formatClassName($classFqn, $contextClassNamespace);
    }


    /**
     * @param string $tableName
     * @param array $columns
     * @return void
     */
    protected function generateTableGeneratedHyperSelection($tableName, $columns)
    {
        $classFqn = $this->config['classes']['selection']['generated'];
        $classFqn = Helpers::substituteClassWildcard($classFqn, $tableName);

        $className = Helpers::extractClassName($classFqn);
        $classNamespace = Helpers::extractNamespace($classFqn);

        $extendsFqn = $this->config['classes']['selection']['base'];
        $extends = Helpers::formatClassName($extendsFqn, $classNamespace);

        $class = new ClassType($className);
        $class->setExtends($extends);

        // Add annotations for methods returning specific row class
        $correspondingHyperRowTableClass = $this->getTableClass('row', $tableName, $classNamespace);
        $methods = [
            'fetch()' => $correspondingHyperRowTableClass . '|FALSE',
            'get($key)' => $correspondingHyperRowTableClass . '|FALSE',
            'current()' => $correspondingHyperRowTableClass . '|FALSE',
        ];

        foreach ($methods as $methodName => $returnType) {
            $class->addDocument("@method $returnType $methodName");
        }

        // Generate methods.selection.where
        foreach ((array)$this->config['methods']['selection']['where'] as $methodTemplate) {
            //dump($tableName, $methodTemplate);

            // Add where methods based on columns
            foreach ($columns as $column => $type) {

                // withFuture*, withPast*
                if ($type === IStructure::FIELD_DATETIME) {

                    $methodName = Helpers::substituteMethodWildcard($methodTemplate, 'Future' . Strings::firstUpper($column));
                    $method = $class->addMethod($methodName);
                    $method->addBody("return \$this->where('$column > NOW()');");
                    $method->addDocument("@return self");

                    $methodName = Helpers::substituteMethodWildcard($methodTemplate, 'Past' . Strings::firstUpper($column));
                    $method = $class->addMethod($methodName);
                    $method->addBody("return \$this->where('$column < NOW()');");
                    $method->addDocument("@return self");
                }

                if ($type === IStructure::FIELD_DATETIME) {
                    $type = '\Nette\Utils\DateTime';
                }

                $methodName = Helpers::substituteMethodWildcard($methodTemplate, $column);
                $method = $class->addMethod($methodName);

                if ($type == 'bool') {
                    $method->addParameter('value', 'TRUE');

                } else {
                    $method->addParameter('value');
                }

                $method->addBody('return $this->where(?, $value);', [$column]);
                $method->addDocument("@param $type \$value");
                $method->addDocument("@return self");
            }
        }

        $code = implode("\n\n", [
            '<?php',
            "/**\n * This is a generated file. DO NOT EDIT. It will be overwritten.\n */",
            "namespace {$classNamespace};",
            $class
        ]);

        $dir = $this->config['dir'] . '/' . 'tables' . '/' . $tableName;
        $file = $dir . '/' . $className . '.php';

        $this->writeIfChanged($file, $code);
    }


    /**
     * @param string $tableName
     * @param array $columns
     * @return void
     */
    protected function generateTableGeneratedHyperRow($tableName, $columns)
    {
        $classFqn = $this->config['classes']['row']['generated'];
        $classFqn = Helpers::substituteClassWildcard($classFqn, $tableName);

        $className = Helpers::extractClassName($classFqn);
        $classNamespace = Helpers::extractNamespace($classFqn);

        $extendsFqn = $this->config['classes']['row']['base'];
        $extends = Helpers::formatClassName($extendsFqn, $classNamespace);

        $class = new ClassType($className);
        $class->setExtends($extends);

        // Add property annotations based on columns
        foreach ($columns as $column => $type) {
            if ($type === IStructure::FIELD_DATETIME) {
                $type = '\Nette\Utils\DateTime';
            }
            $class->addDocument("@property-read $type \$$column");

            if (is_array($this->config['methods']['row']['column'])
                && count($this->config['methods']['row']['column']) > 0
                && in_array('get*', $this->config['methods']['row']['column'])

            ) {
                $columnAlternative = Strings::firstLower(Helpers::underscoreToCamel($column));

                if ($columnAlternative != $column) {
                    $class->addDocument("@property-read $type \$$columnAlternative");
                }
            }
        }

        // Generate methods.row.ref
        foreach ((array)$this->config['methods']['row']['ref'] as $methodTemplate) {

            // Generate 'ref' methods
            foreach ($this->structure->getBelongsToReference($tableName) as $referencingColumn => $referencedTable) {
                $methodName = Helpers::substituteMethodWildcard($methodTemplate, Strings::replace($referencingColumn, '~_id$~'));

                $returnType = $this->getTableClass('row', $referencedTable, $classNamespace);

                $class->addMethod($methodName)
                    ->addBody('return $this->ref(?, ?);', [$referencedTable, $referencingColumn])
                    ->addDocument("@return $returnType");
            }
        }

        // Generate methods.row.related
        foreach ((array)$this->config['methods']['row']['related'] as $methodTemplate) {

            // Generate 'related' methods
            foreach ($this->structure->getHasManyReference($tableName) as $relatedTable => $referencingColumns) {

                foreach ($referencingColumns as $referencingColumn) {

                    // Find longest common prefix between $referencingColumn and (this) $tableName
                    $thisTableWords = Strings::split($tableName, '#_#');
                    $relatedTableWords = Strings::split($relatedTable, '#_#');

                    for ($i = 0; $i < count($relatedTableWords) && $i < count($thisTableWords); $i++) {
                        if ($thisTableWords[$i] == $relatedTableWords[$i]) {
                            array_shift($relatedTableWords);

                        } else {
                            break;
                        }
                    }

                    if (count($relatedTableWords) > 0) {
                        $result = '';
                        foreach ($relatedTableWords as $word) {
                            Strings::firstUpper($word);
                            $result .= Strings::firstUpper($word);
                        }

                    } else {
                        $result = Helpers::underscoreToCamel($relatedTable);
                    }

                    switch (Strings::lower(Strings::substring($relatedTable, -1))) {
                        case 's':
                            // nothing
                            break;
                        case 'y':
                            $methodName = Strings::replace($result, '#y$#', 'ies');
                            break;
                        default:
                            $result .= 's';
                            break;
                    };

                    if (count($referencingColumns) > 1) {
                        $result .= 'As' . Helpers::underscoreToCamel(Strings::replace($referencingColumn, '~_id$~'));
                    }

                    $methodName = Helpers::substituteMethodWildcard($methodTemplate, $result);

                    $returnType = $this->getTableClass('selection', $relatedTable, $classNamespace);

                    $class->addMethod($methodName)
                        ->addBody('return $this->related(?, ?);', [$relatedTable, $referencingColumn])
                        ->addDocument("@return $returnType");
                }
            }
        }

        // Generate methods.row.column
        foreach ((array)$this->config['methods']['row']['column'] as $methodTemplate) {

            // Generate column getters
            foreach ($columns as $column => $type) {
                $methodName = Helpers::substituteMethodWildcard($methodTemplate, $column);

                $returnType = $type;

                $class->addMethod($methodName)
                    ->addBody('return $this->?;', [$column])
                    ->addDocument("@return $returnType");
            }
        }

        $code = implode("\n\n", [
            '<?php',
            "/**\n * This is a generated file. DO NOT EDIT. It will be overwritten.\n */",
            "namespace {$classNamespace};",
            $class
        ]);

        $dir = $this->config['dir'] . '/' . 'tables' . '/' . $tableName;
        $file = $dir . '/' . $className . '.php';

        $this->writeIfChanged($file, $code);
    }


    /**
     * @param string $type selection|row
     * @param string $tableName
     */
    protected function generateTableClass($type, $tableName)
    {
        $classFqn = $this->config['classes'][$type]['*'];
        $classFqn = Helpers::substituteClassWildcard($classFqn, $tableName);

        $className = Helpers::extractClassName($classFqn);
        $classNamespace = Helpers::extractNamespace($classFqn);

        $extendsFqn = $this->config['classes'][$type]['generated'];
        $extendsFqn = Helpers::substituteClassWildcard($extendsFqn, $tableName);
        $extends = Helpers::formatClassName($extendsFqn, $classNamespace);

        $dir = $this->config['dir'] . '/' . 'tables' . '/' . $tableName;

        $this->generateEmptyClass($classNamespace, $className, $extends, $dir);
    }

}