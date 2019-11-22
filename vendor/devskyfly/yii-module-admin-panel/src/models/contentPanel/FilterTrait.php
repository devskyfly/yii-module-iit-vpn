<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use devskyfly\php56\types\Arr;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

trait FilterTrait
{
    public function init()
    {
        
    }
    
    public function search($params,$parent_section_id)
    {
        $query = static::find()->where(['_section__id'=>$parent_section_id]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        
        $strict_fields_array=["id","active"];
        $fields=$this->getFields();
        
        foreach ($fields as $field){
            if(Arr::inArray($field, $strict_fields_array)){
                $query->andFilterWhere([$field => $this[$field]]);
            }else{
                $query->andFilterWhere(['like', $field, $this[$field]]);
            }
        }
           
        return $dataProvider;
    }
    
    public static function tableName()
    {
        $parent=new parent();
        return $parent::tableName();
    }
    
    public function getFields()
    {
        $result=[];
        $rules=$this->rules();
        foreach ($rules as $rule){
            if(isset($rule[0])){
                $item=$rule[0];
                if(Arr::isArray($item)){
                    $result=ArrayHelper::merge($result,$item);
                }else{
                    $result[]=$item;
                }
            }
        }
        return $result;
    }
}