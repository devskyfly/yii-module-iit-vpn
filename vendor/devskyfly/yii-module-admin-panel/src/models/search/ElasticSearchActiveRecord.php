<?php
namespace devskyfly\yiiModuleAdminPanel\models\search;

use devskyfly\php56\types\Vrbl;
use Yii;
use yii\elasticsearch\ActiveRecord;
use phpDocumentor\Reflection\Types\Static_;



class ElasticSearchActiveRecord extends ActiveRecord
{
    /**
     * 
     * @throws \InvalidArgumentException
     * @return []
     */
    protected static function getSearchSettings()
    {
        $module=Yii::$app->getModule('admin-panel');
        if(Vrbl::isNull($module)){
          throw new \InvalidArgumentException('Param $module is null.');
        }
        return $module->search_settings;
    }
    
    /**********************************************************************/
    /** Overload **/
    /**********************************************************************/
    
    /**
     *
     * @return string
     */
    public static function index()
    {
        $settings=static::getSearchSettings();
        return $settings['index'];
    }
    
    /**
     * 
     * @return string
     */
    public static function type()
    {
        $settings=static::getSearchSettings();
        return $settings['type'];
    }
    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return ['id', 'name', 'content', 'route'];
    }
}

