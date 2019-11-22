<?php
namespace devskyfly\yiiModuleAdminPanel;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;

/**
 * This module give opportunity to create admin panel
 * 
 * @author devskyfly
 *
 */
class Module extends \yii\base\Module
{   
    const CSS_NAMESPACE='devskyfly-yii-module-admin-panel';
    
    
    /**
     * Upload dir path for application need to configurate.
     * 
     * @var string
     */
    public $upload_dir='';
    
    /**
     * Elastic search url or ip with port.
     * 
     * @var string
     */
    public $search_settings=[];

    /**
     * Store absolute path of current module view path
     *
     * Because AbstractContentPanelController is used by external controllers
     * 
     * @var string
     */
    private $_module_view_path = '';
    
    public function init()
    {
        
        parent::init();
        Yii::setAlias("@devskyfly/yiiModuleAdminPanel", __DIR__);
        $this->initUploadDir();
        $this->checkSearchSettings();
        
        /**
         * Define controller namespace
         */
        if(Yii::$app instanceof \yii\console\Application){
            $this->controllerNamespace='devskyfly\yiiModuleAdminPanel\console';
        }else{
            $this->setAbsoluteViewPath();
        }
    }
    
    /**********************************************************************/
    /** Search **/
    /**********************************************************************/
    
    protected function checkSearchSettings()
    {
            if(!Arr::isArray($this->search_settings)){
                throw new \InvalidArgumentException('Property $search_settigs is not array type.');
            }
            
            if(!Vrbl::isEmpty($this->search_settings)){
                if((!Str::isString($this->search_settings['elastic_hosts']))
                    &&(!Arr::isArray($this->search_settings['elastic_hosts']))){
                    throw new \InvalidArgumentException('Property $search_settings[\'elastic_hosts\'] is not string or array type.');
                }
                
                if(!Str::isString($this->search_settings['index'])){
                    throw new \InvalidArgumentException('Property $search_settings[\'index\'] is not string type.');
                }
                
                if(isset($this->search_settings['index_settings'])
                    &&(!Arr::isArray($this->search_settings['index_settings']))){
                    throw new \InvalidArgumentException('Property $search_settings[\'index\'] is not array type.');
                }
                
                if((!Str::isString($this->search_settings['type']))){
                    throw new \InvalidArgumentException('Property $search_settings[\'type\'] is not string type.');
                }
                
                if(isset($this->search_settings['type_mappings'])
                    &&(!Arr::isArray($this->search_settings['type_mappings']))){
                    throw new \InvalidArgumentException('Property $search_settings[\'type_mappings\'] is not array type.');
                }
            }

    }
    
    /**********************************************************************/
    /** UploadDir **/
    /**********************************************************************/
    
    /**
     * Return upload_dir property value.
     * 
     * @return string
     */
    public function getUploadDir()
    {
        return $this->upload_dir;
    }
    
    /**
     * 
     * @throws \InvalidArgumentException
     * @throws \yii\base\Exception
     */
    public function initUploadDir()
    {
        if(Vrbl::isEmpty($this->upload_dir)){
            $this->upload_dir="@common/upload";
        }
        if(!Str::isString($this->upload_dir)){
            throw new \InvalidArgumentException('Param $path is not string type.');
        }
        
        $path=Yii::getAlias($this->upload_dir);
        
        if(!file_exists(Yii::getAlias($this->upload_dir))){
            $result=FileHelper::createDirectory($path);
            if(!$result){
                throw new \Exception("Can't create dir $path");
            }
        }
    }
    
    /**********************************************************************/
     /** AbsoluteViewPath **/
     /**********************************************************************/
    
    /**
     * Set _module_view_path property
     * @return string
     */
    public function setAbsoluteViewPath()
    {
        return $this->_module_view_path=__DIR__.'/views';
    }
    
    /**
     * Return _module_view_path property
     * @return string
     */
    public function getAbsoluteViewPath()
    {
        return $this->_module_view_path;
    }
}