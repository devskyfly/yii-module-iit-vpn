<?php
namespace devskyfly\yiiModuleAdminPanel\console\service;

use Yii;
use yii\console\Controller;
use yii\db\Migration;
use yii\helpers\BaseConsole;

class DbController extends Controller
{
    public function actionClear()
    {
        try {
            $excluded_tables=['migration','user'];
            $db=Yii::$app->db;
            $schema=$db->schema;
            $tables=$schema->getTableNames();
            
            $migration=new Migration();
            foreach ($tables as $table){
                if(!in_array($table, $excluded_tables)){
                    $migration->truncateTable($table);
                }
            }
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage());
            BaseConsole::stdout(PHP_EOL);
            return -1;
        }
        catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage());
            return -1;
        }
        
        return 0;
    }
}