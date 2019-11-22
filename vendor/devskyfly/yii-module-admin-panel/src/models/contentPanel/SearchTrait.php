<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Obj;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Implements devskyfly\yiiModuleAdminPanel\models\contentPanel\SearchInterface
 * @author devskyfly
 *
 */
trait SearchTrait
{
    /**
     * @inheritdoc
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\SearchInterface::getById()
     */
    public static function getById($id)
    {
        //$id=Nmbr::toIntegerStrict($id);
        if((!Str::isString($id))&&(!Nmbr::isInteger($id)))
        {
            throw new \InvalidArgumentException('Param id is not string or interger type');
        }
        return static::find()->where(['id'=>$id])->one();
    }
    
    /**
     * @inheritdoc
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\SearchInterface::getByCode()
     */
    public static function getByCode($code)
    {
        if((!Str::isString($id)))
        {
            throw new \InvalidArgumentException('Param id is not string type');
        }
        return static::find()->where(['id'=>$id])->one();
    }
}