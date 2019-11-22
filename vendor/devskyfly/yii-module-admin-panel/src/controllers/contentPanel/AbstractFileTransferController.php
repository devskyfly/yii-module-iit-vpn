<?php
namespace devskyfly\yiiModuleAdminPanel\controllers\contentPanel;

use devskyfly\php56\core\Cls;
use devskyfly\php56\libs\fileSystem\Files;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractFile;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;

abstract class AbstractFileTransferController extends Controller
{
    /**
     * Keep classname that extends AbstractFile
     * @var string
     */
    public $file_class="";
    /**
     * return classname that extends AbstractFile
     */
    abstract public function fileClass();
    
    public function init()
    {
        parent::init();
        $this->file_class=$this->fileClass();
        if(!Cls::isSubClassOf($this->file_class, AbstractFile::class)){
            throw new \InvalidArgumentException('Property $file_class is not '.AbstractFile::class.' extesion.');
        }
    }
    
    /**
     * 
     * @param string $guid
     * @param Response $response
     * @throws \InvalidArgumentException
     * @throws NotFoundHttpException
     * @throws \yii\web\NotFoundHttpException
     * @return \yii\base\Response
     */
    public function sendFileByGuid($guid,$response)
    {
        if(!Str::isString($guid)){
            throw new \InvalidArgumentException('Param $guid is not string type.');
        }
        if(mb_strlen($guid)!==36){
            throw new \InvalidArgumentException('Param $guid is not right format.');
        }
        if(!Obj::isA($response,Response::class)){
            
        }
        $file_cls=$this->file_class;
        $file=$file_cls::getByGuid($guid);
        
        if(!$file){
            throw new NotFoundHttpException();
        }
        
        $file_path = Yii::getAlias($file['path']);
        
        $file_path= realpath($file_path);
        
        if(!Files::fileExists($file_path)){
            throw new NotFoundHttpException();
        }
        
        $file_name=basename($file_path);
        // check filename for allowed chars (do not allow ../ to avoid security issue: downloading arbitrary files)
        
        /* if (!preg_match('/^[a-z0-9]+\.[a-z0-9]+$/i', $file_name) || !is_file($file_path)) {
            throw new \yii\web\NotFoundHttpException('The file does not exists.');
        } */
        
        return Yii::$app->response->sendFile($file_path, $file_name);
    }
}