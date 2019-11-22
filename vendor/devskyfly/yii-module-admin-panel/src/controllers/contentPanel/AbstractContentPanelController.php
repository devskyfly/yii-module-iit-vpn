<?php
namespace devskyfly\yiiModuleAdminPanel\controllers\contentPanel;

use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractUnnamedEntity;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;

/**
 * Provide common way on view and edit of entities and sections
 * 
 * @author devskyfly
 *
 */
abstract class AbstractContentPanelController extends Controller
{
    /**
     * Contain entity class to have access to static methods of class
     * 
     * @var \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstructEntity;
     */
    protected $entity_cls;
    
    /**
     * Contain entity filter class to have access to static methods of class
     *
     * @var \devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;
     */
    protected $entity_filter_cls;
    
    /**
     * Contain columns declaration to render in GridView widget
     * 
     * @var array
     */
    protected $entity_columns=[];
    
    /**
     * Contain columns declaration to render in GridView widget in select list
     *
     * @var array
     */
    protected $entity_select_list_columns=[];
    
    /**
     * Contain section class to have access to static methods of class
     *
     * @var \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstructSection;
     */
    protected $section_cls;
    
    /**
     *
     * @var callable
     */
    protected $entity_editor_views=null;
    
    /**
     * 
     * @var callable
     */
    protected $section_editor_views=null;
        
    /**
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    abstract public static function entityCls();
    
    /**
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem | null
     */
    public static function entityFilterCls()
    {
        return null;
    }
    
    /**
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    abstract public static function sectionCls();
    
    /**
     * Return label of item to use it in interface
     * 
     * @return string
     */
    abstract public function itemLabel();
    
    /**
     * Return entity class name
     * @throws \InvalidArgumentException
     * @return string
     */
    public static function getEntityCls()
    {
        $cls=static::entityCls();
        if((!Cls::isSubClassOf($cls, AbstractUnnamedEntity::class))
            &&(!Vrbl::isEmpty($cls))
        ){
            throw new \InvalidArgumentException('$cls is not subclass of '.AbstractUnnamedEntity::class.' type.');
        }
        return $cls;
    }
    
    public static function getEntityFilterCls()
    {
        $cls=static::entityFilterCls();
        if((!Cls::isSubClassOf($cls, FilterInterface::class))
            &&(!Vrbl::isEmpty($cls))
            ){
                throw new \InvalidArgumentException('$cls is not subclass of '.FilterInterface::class.' type.');
        }
        return $cls;
    }
    
    /**
     * Return entity class name
     * @throws \InvalidArgumentException
     * @return string
     */
    public static function getSectionCls()
    {
        $cls=static::sectionCls();
        if((!Cls::isSubClassOf($cls, AbstractSection::class))
            &&(!Vrbl::isEmpty($cls))
        ){
            throw new \InvalidArgumentException('$cls is not '.AbstractSection::class.' type.');
        }
        return $cls;
    }
    
    /**
     * @return callable
     */
    abstract public function entityEditorViews();
    
    /**
     * @return callable
     */
    abstract public function sectionEditorViews();
    
    /**
     * Define columns for GridView widget
     * 
     * You can redeclarate this method to define your own columns
     * @return []
     */
    public function entityColumns()
    {
        $columns=[
            ['class' => 'yii\grid\SerialColumn']
        ];
        
        $unname_entity_columns=['active','create_date_time','change_date_time'];
        
        $entity_columns=$unname_entity_columns;
        $entity_columns[]='name';
        
        if(Cls::isSubClassOf($this->entityCls(), AbstractEntity::class)){
            $columns=ArrayHelper::merge($columns, $entity_columns);
        }elseif(Cls::isSubClassOf($this->entityCls(), AbstractUnnamedEntity::class)){
            $columns=ArrayHelper::merge($columns, $unname_entity_columns);
        }
        
        return $columns;
    }

    /**
     * You can add your own columns to grid view
     * 
     * @return array
     */
    public function entityCustomColumns()
    {
        return [];
    }

    public function entityColumnsForSelectList()
    {
        return [
            ['class' => 'devskyfly\yiiModuleAdminPanel\grid\column\LinkColumn']
        ];
    }
    
    /**
     * Define columns for GridView widget
     *
     * You can redeclarate this method to define your own columns
     * @return []
     */
    public function entityColumnsForEdit()
    {
        return [ 
            [   
                'class'=>'yii\grid\ActionColumn',
                
                'buttons'=>[
                    'delete'=>function($url,$model,$key){
                        
                    $text = '';
                    $options = [
                        'class' => 'glyphicon glyphicon-trash'
                    ];
                    $url = Url::toRoute(['entity-delete','entity_id'=>$model->id]);
                    return Html::a($text,[$url],
                        [
                            'class'=>'glyphicon glyphicon-trash',
                            'data-confirm' => 'Удалить?',
                        ]
                        );
                    }, 
                    'update'=>function($url,$model,$key){
                    
                        $text = '';
                        $options = [
                            'class' => 'glyphicon glyphicon-pencil'
                        ];
                        $url = Url::toRoute(['entity-edit','entity_id'=>$model->id]);
                        return Html::a($text, $url, $options);
                    } 
                ],
                
                'visibleButtons'=>[
                     'view'=>function($url,$model,$key){
                     return false;
                     },
                     'update'=>function($url,$model,$key){
                     return true;
                     },
                     'delete'=>function($url,$model,$key){
                        return true;
                     }
                ] 
            ]
        ];
    }
    /**
     * Set view path to child controller, to use this module views from other places
     * 
     * {@inheritDoc}
     * @see \yii\base\Controller::setViewPath()
     */
    public function setViewPath($view_path="")
    {
        $module=Yii::$app->getModule('admin-panel');
        
        if(Vrbl::isNull($module)){
            throw \Exception('admin-panel module is not loaded.');
        }
        
        $view_path=$module->getAbsoluteViewPath();
        parent::setViewPath($view_path);
    }
    
    /**********************************************************************/
    /** INIT **/
    /**********************************************************************/
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\BaseObj::init()
     * @throws \InvalidArgumentException;
     */
    public function init()
    {
        $this->entity_cls=static::getEntityCls();
        $this->entity_filter_cls=static::getEntityFilterCls();
        $this->section_cls=static::getSectionCls();
        
        $this->entity_editor_views=$this->entityEditorViews();
        $this->section_editor_views=$this->sectionEditorViews();
        
        $this->entity_columns=ArrayHelper::merge(
            $this->entityColumnsForEdit(),
            $this->entityColumns(), 
            $this->entityCustomColumns()
        );
        
        $this->entity_select_list_columns=ArrayHelper::merge(
            $this->entityColumnsForSelectList(),
            $this->entityColumns(),
            $this->entityCustomColumns()
        );
        
        $this->setViewPath();
    }
    
    /**********************************************************************/
    /** ACTIONS **/
    /**********************************************************************/
    
    /**
     * Give opportunity to view sections and entities lists
     * @var null|integer $parent_section_id
     * @var null|integer $page
     * @throws \InvalidArgumentException
     */
    public function actionIndex($parent_section_id=null,$page=null)
    {
        if((!Vrbl::isNull($parent_section_id))
            &&(!Str::isString($parent_section_id))){
            throw new \InvalidArgumentException('Param parent_section_id is not string type.');
        }
        $page=Nmbr::toInteger($page);
        if((!Vrbl::isNull($page))
            &&(!Nmbr::IsInteger($page))){
                throw new \InvalidArgumentException('Param page is not integer type.');
        }
        $entity_filter_cls=$this->entity_filter_cls;
        $entity_cls=$this->entity_cls;
        $section_cls=$this->section_cls;
        $entity_columns=$this->entity_columns;
        return $this->render('content-panel/index',compact("entity_filter_cls","entity_cls","section_cls","parent_section_id","page","entity_columns"));
    }
    
    /**********************************************************************/
    /** ENTITY **/
    /**********************************************************************/
    
    /**
     * Give opportunity to select entity in module window
     */
    public function actionEntitySelectList($parent_section_id=null,$page=null)
    {
        if((!Vrbl::isNull($parent_section_id))
            &&(!Str::isString($parent_section_id))){
                throw new \InvalidArgumentException('Param parent_section_id is not string type.');
        }
        $page=Nmbr::toInteger($page);
        if((!Vrbl::isNull($page))
            &&(!Nmbr::IsInteger($page))){
                throw new \InvalidArgumentException('Param page is not integer type.');
        }
        
        $entity_cls=$this->entity_cls;
        $section_cls=$this->section_cls;
        $entity_columns=$this->entity_select_list_columns;
        return $this->render('content-panel/entity-select-list',compact("entity_cls","section_cls","parent_section_id","page","entity_columns"));
    }
    
    /**
     * Give opportunity to create entity item
     */
    public function actionEntityCreate($parent_section_id=null)
    {
        $item=new $this->entity_cls();
        
        if(!Vrbl::isNull($parent_section_id)){
            $item->_section__id=$parent_section_id;
        }
        
        $views=$this->entity_editor_views;
        $request=Yii::$app->request;
        if($request->isPost){
            $post=$request->post();
            $item->loadLikeItem($post);
            if($item->saveLikeItem()){
                $this->redirect(Url::toRoute(['entity-edit','entity_id'=>$item->id]));
            }
        }
        return $this->render('content-panel/entity-edit',compact("item","views"));
    }
    
    /**
     * Give opportunity to edit entity item
     */
    public function actionEntityEdit($entity_id=null)
    {
        if(Vrbl::isNull($entity_id)){
            throw new NotFoundHttpException();
        }
        $item=$this->entity_cls;
        $views=$this->entity_editor_views;
        $request=Yii::$app->request;
        
        $entity_id=Nmbr::toIntegerStrict($entity_id);
        $item=$item::getById($entity_id);
        if(Vrbl::isNull($item)){
            throw new NotFoundHttpException();
        }
        if($request->isPost){
            $post=$request->post();
            $item->loadLikeItem($post);
            $item->saveLikeItem();
        }
        return $this->render('content-panel/entity-edit',compact("item","views"));
    }
    
    /**
     * Give opportunity to delete entity item
     */
    public function actionEntityDelete($entity_id=null)
    {
        $item=$this->entity_cls;
        $item=$item::getById($entity_id);
        
        if(Vrbl::isNull($item)){
            throw new NotFoundHttpException();
        }else{
            $parent_section=$item->getParentSection();
            
            if($item->deleteLikeItem()===true){
                if($parent_section){
                    $this->redirect(['index','parent_section_id'=>$parent_section->id]);
                }else{
                    $this->redirect(['index']);
                }
            }else{
                return $this->render('content-panel/entity-delete');
            }
        }  
    }
    
    /**********************************************************************/
    /** SECTION **/
    /**********************************************************************/
    
    /**
     * Give opportunity to select section in module window
     */
    public function actionSectionSelectList($parent_section_id=null)
    {
        if((!Vrbl::isNull($parent_section_id))
            &&(!Str::isString($parent_section_id))){
                throw new \InvalidArgumentException('Param parent_section_id is not string type.');
        }
        
        $section_cls=$this->section_cls;
        return $this->render('content-panel/section-select-list',compact("section_cls","parent_section_id"));
    }
    
    /**
     * Give opportunity to create section item
     */
    public function actionSectionCreate($parent_section_id=null)
    {
        $item=new $this->section_cls();
        
        if(!Vrbl::isNull($parent_section_id)){
            $item->__id=$parent_section_id;
        }
        
        $views=$this->section_editor_views;
        $request=Yii::$app->request;    
        if($request->isPost){
            $post=$request->post();
            $item->loadLikeItem($post);
            if($item->saveLikeItem()){
                $this->redirect(Url::toRoute(['section-edit','section_id'=>$item->id]));
            }
        }
        return $this->render('content-panel/section-edit',compact("item","views"));
    }
    
    /**
     * Give opportunity to edit section item
     */
    public function actionSectionEdit($section_id=null)
    {
        $item=$this->section_cls;
        $views=$this->section_editor_views;
        $request=Yii::$app->request;
        $item=$item::getById($section_id);
        if(Vrbl::isNull($item)){
            throw new NotFoundHttpException();
        }
        if($request->isPost){
            $post=$request->post();
            $item->loadLikeItem($post);
            $item->saveLikeItem();
        }
        return $this->render('content-panel/section-edit',compact("item","views"));
    }
    
    /**
     * Give opportunity to delete section item
     */
    public function actionSectionDelete($section_id=null)
    {
        $item=$this->section_cls;
        $item=$item::getById($section_id);
        
        if(Vrbl::isNull($item)){
            throw new NotFoundHttpException();
        }else{
            $parent_section=$item->getParentSection();
            
            if($item->deleteLikeItem()===true){
                if($parent_section){
                    $this->redirect(['index','parent_section_id'=>$parent_section->id]);
                }else{
                    $this->redirect(['index']);
                }
            }else{
                return $this->render('content-panel/section-delete');
            }
        }  
    }
}