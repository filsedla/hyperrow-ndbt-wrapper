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

/**
 *
 */
final class RowClassesBuilder extends Object
{

    /** @var Context */
    private $context;

    /** @var string */
    private $tempDir;


    /**
     * @param string $tempDir
     * @param Context $context
     */
    function __construct($tempDir, Context $context)
    {
        $this->tempDir = $tempDir;
        $this->context = $context;
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
            $classes[] = $class;
        }
        $code = implode("\n\n", array_merge(['<?php', 'namespace Filsedla\CustomRowClass;'], $classes));
        file_put_contents($this->tempDir . DIRECTORY_SEPARATOR . "/row_classes_base_generated.php", $code);
    }

} 