<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use yii\helpers\ArrayHelper;

/**
 * This class represent entity
 * 
 * @author devskyfly
 * @property strin $name
 * @property string $_section__id
 */
abstract class AbstractEntity extends AbstractUnnamedEntity
{
    /**
     *
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        $rules=parent::rules();
        $new_rules=[
            [["name"],"required"],
            [["code"],"string"],
            [["name"],"string"],
            [["_section__id"],"number"]
        ];
        $rules=ArrayHelper::merge($rules, $new_rules);
        return $rules;
    }

}