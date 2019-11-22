<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use Ramsey\Uuid\Uuid;
use devskyfly\php56\libs\fileSystem\Files;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use Yii;
use inblank\transliter\Transliter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use devskyfly\yiiModuleAdminPanel\Module;

/**
 * 
 * @author devskyfly
 * @property string $item_table
 * @property string $__id
 * @property string $path
 * @property string $guid
 */
abstract class AbstractFile extends AbstractItemExtension
{
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::init()
     * @throws \Ramsey\Uuid\Exception\UnsatisfiedDependencyException
     */
    public function init()
    {
        parent::init();
        if($this->isNewRecord){
            $uuid4=Uuid::uuid4();
            $this->guid=$uuid4->toString();
        }
    }
    
    /**
     * 
     * @param string$guid
     * @throws \InvalidArgumentException
     * @return AbstractFile | null
     */
    public static function getByGuid($guid)
    {
        if(!Str::isString($guid)){
            throw new \InvalidArgumentException('Param $guid is not string type.');
        }
        return static::find()->where(['guid'=>$guid])->one();
    }
    
    /**
     * File upload handler
     * @throws \Exception
     */
    protected function handleFileUpload()
    {
        $master_item=$this->master_item;
        $file= UploadedFile::getInstance($this->master_item,$this->extension_name);
        if($file){
            
            //module
            $module=Module::getInstance();
            
            if(Vrbl::isNull($module)){
                throw \Exception('admin-panel module is not loaded.');
            }
            $module->initUploadDir();
            $upload_dir=$module->upload_dir;
            //dir_path
            $dir_alias=$upload_dir.'/'.$master_item::tableName().'/'.$master_item->id;
            $dir_path=Yii::getAlias($upload_dir.'/'.$master_item::tableName().'/'.$master_item->id);
            if(!file_exists($dir_path)){
                $result=FileHelper::createDirectory($dir_path);
                if(!$result){
                    throw new \Exception("Can't create dir $dir_path.");
                }
            }
            //file
            $translater=new Transliter();
            $translited_base_name=$translater->translate($file->baseName);
            $path=$dir_path.'/'.$translited_base_name.'.'.$file->extension;
            $path_alias=$dir_alias.'/'.$translited_base_name.'.'.$file->extension;
            $this->path=$path_alias;
            
            $result=$file->saveAs(Yii::getAlias($path));
            if(!$result){
                throw new \Exception("Can't create file $path.");
            }
        }
    } 
    
    /**********************************************************************/
    /** REDECLARATION **/
    /**********************************************************************/
    
   public function afterDelete()
   {
       parent::afterDelete();
       
       try{
           $file_path=Yii::getAlias($this->path);
           if(file_exists($file_path)){
                $result=Files::deleteFile($file_path);
           }    
       }catch (\Throwable $e){
           Yii::info($e->getMessage(),get_class($this));
       }catch(\Exception $e){
           Yii::info($e->getMessage(),get_class($this));
       }
   }
    
   public function beforeSave($insert)
   {
       if(!parent::beforeSave($insert)){
           return false;
       }
       
       $this->handleFileUpload();
       
       return true;
   }
    
    /**
     *
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        $rules=parent::rules();
        
        $new_rules=[
            [["guid"],"required"],
            [["path","guid"],"string"]
        ];
        
        $rules=ArrayHelper::merge($rules, $new_rules);
        return $rules;
    }
    
    public static function tableName()
    {
        return "file";
    }
}