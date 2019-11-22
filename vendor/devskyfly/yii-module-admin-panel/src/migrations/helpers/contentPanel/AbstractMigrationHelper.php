<?php
namespace devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel;

use yii\db\ColumnSchemaBuilder;
use yii\db\Migration;

/**
 * Define how to extend Migration class to easy tables create
 * 
 * @author devskyfly
 *
 */
abstract class AbstractMigrationHelper extends Migration
{
    /**
     * @return ColumnSchemaBuilder[]
     */
    abstract public function getFieldsDefinition();
}