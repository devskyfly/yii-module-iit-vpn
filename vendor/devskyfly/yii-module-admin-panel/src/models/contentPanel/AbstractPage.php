<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * 
 * @author devskyfly
 * @property string $item_table
 * @property string $__id
 * @property string $preview_text
 * @property string $detail_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $preview_img
 * @property string $detail_img
 */
abstract class AbstractPage extends AbstractItemExtension
{
    /**********************************************************************/
    /** REDECLARATE **/
    /**********************************************************************/
    
    /**
     *
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        $rules=parent::rules();
        $new_rules=[
            [["preview_text","detail_text","title","keywords","description","preview_img","detail_img"],"string"],
        ];
        $rules=ArrayHelper::merge($rules, $new_rules);
        return $rules;
    }
    
    public static function tableName()
    {
        return "page";
    }
}