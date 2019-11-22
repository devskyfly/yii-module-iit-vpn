<?php
namespace devskyfly\yiiModuleAdminPanel\models\contentPanel;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\php56\core\Cls;
use devskyfly\php56\types\Vrbl;
use yii\helpers\Inflector;
use yii\base\Event;

/**
 * 
 * @author devskyfly
 * @property integer $id
 * @property string $code
 * @property string $active
 * @property integer $sort
 * @property string $create_date_time
 * @property string $change_date_time
 */
abstract class AbstractItem extends ActiveRecord implements SearchInterface
{
    const ACTIVE = 'Y';
    const INACTIVE = 'N';
    
    const EVENT_BEFORE_SAVE_LIKE_ITEM = 'before_save_like_item';
    const EVENT_AFTER_SAVE_LIKE_ITEM = 'after_save_like_item';
    const EVENT_BEFORE_INSERT_LIKE_ITEM = 'before_insert_like_item';
    const EVENT_AFTER_INSERT_LIKE_ITEM = 'after_insert_like_item';
    const EVENT_BEFORE_DELETE_LIKE_ITEM = 'before_delete_like_item';
    const EVENT_AFTER_DELETE_LIKE_ITEM = 'after_delete_like_item';

    use SearchTrait;
    
    /**
     * Assoc array of ActiveRecord instances
     * @var yii\db\ActiveRecord[];
     */
    public $extensions=[];
    
    public $binders=[];
    
    /**********************************************************************/
    /** INIT **/
    /**********************************************************************/
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::init()
     */
    public function init(){
        parent::init();
        
        //Init empty extensions objects
        $this->initExtensions();
        $this->initBinders();
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterFind()
     */
    public function afterFind()
    {
        //Init data
        //$date=new \DateTime($this->change_date_time);
        //$this->initCreateAndChangeDateTime($date,false);
        //Init extensions objects by related item
        $this->initExtensions();
        $this->initBinders();
        $this->trigger(static::EVENT_AFTER_FIND);
    }
    
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            $this->initCreateAndChangeDateTime();
        }else{
            return false;
        }
        
        return true;
    }
    
    /**
     * Define dependence between item property and its class name
     *
     * @return []|["prop"=>yii\db\ActiveRecord, ...]
     */
    public function extensions()
    {
        return [];
    }
    
    /**
     * Define binders between item property and its class name
     * 
     * @return []|["prop"=>devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractBinder]
     */
    public function binders()
    {
        return [];
    }

    /**********************************************************************/
    /** Crud **/
    /**********************************************************************/
    
    /**
     * Insert item and binded elements
     * 
     * @return boolean
     */
    public function insertLikeItem()
    {
        $this->trigger(static::EVENT_BEFORE_INSERT_LIKE_ITEM);
        Event::trigger(static::className(), static::EVENT_BEFORE_INSERT_LIKE_ITEM, new ItemEventMessage(['obj'=>$this]));
        
        $result=true;
        $transaction=static::getDb()->beginTransaction();
        try{
            $result=$this->insert();
            foreach ($this->extensions as $name=>$extension){
                $extension->initByItem($this,$name);
                if($extension->validate()){
                    $result=$result&&$extension->insert();
                }else{
                    ArrayHelper::merge($this->errors,$extension->errors);
                }               
            }
            
            if(Obj::isA(Yii::$app, yii\web\Application::class)){
                $request=Yii::$app->request;
                if(!Vrbl::isNull($request)){
                    foreach ($this->binders as $name=>$bind_cls){
                        $bind_cls::clear($this->id);
                        $bind_short_cls=(new \ReflectionClass($bind_cls))->getShortName();
                        $request_binders=$request->post($bind_short_cls,[]);
                        if(!Vrbl::isEmpty($request_binders)){
                            foreach($request_binders['slave_id'] as $item){
                                if(Vrbl::isEmpty($item)){continue;}
                                $bind=new $bind_cls();
                                $bind->master_id=$this->id;
                                $bind->slave_id=$item;
                                if($bind->validate()){
                                    $result=$result&&$bind->insert();
                                }
                            }
                        }
                    }
                }
            }
            
            $transaction->commit();
        }catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
            //return false;
        }catch(\Throwable $e){
            throw $e;
            $transaction->rollBack();
            //return false;
        }
        $this->trigger(static::EVENT_AFTER_INSERT_LIKE_ITEM);
        Event::trigger(static::className(), static::EVENT_AFTER_INSERT_LIKE_ITEM, new ItemEventMessage(['obj'=>$this]));
        
        return $result;
    }
    
   /**
    * Save item and binded elements
    * 
    * @return boolean
    */
    public function saveLikeItem()
    {
        if($this->isNewRecord)
        {
            return  $this->insertLikeItem();
        }
        $this->trigger(static::EVENT_BEFORE_SAVE_LIKE_ITEM);
        Event::trigger(static::className(), static::EVENT_BEFORE_SAVE_LIKE_ITEM, new ItemEventMessage(['obj'=>$this]));

        $result=true;
        $transaction=$this->db->beginTransaction();
        try{
            
            $result=$this->save();
            foreach ($this->extensions as $name=>$extension){
                $extension->initByItem($this,$name);
                if($extension->validate()){
                    $result=$result&&$extension->save();
                }else{
                    ArrayHelper::merge($this->errors,$extension->errors);
                }
            }
            if(Obj::isA(Yii::$app, yii\web\Application::class)){
                $request=Yii::$app->request;
                if(!Vrbl::isNull($request)){
                    foreach ($this->binders as $name=>$bind_cls){
                        $bind_cls::clear($this->id);
                        $bind_short_cls=(new \ReflectionClass($bind_cls))->getShortName();
                        $request_binders=$request->post($bind_short_cls,[]);
                        if(!Vrbl::isEmpty($request_binders)){
                            foreach($request_binders['slave_id'] as $item){
                                if(Vrbl::isEmpty($item)){continue;}
                                $bind=new $bind_cls();
                                $bind->master_id=$this->id;
                                $bind->slave_id=Nmbr::toIntegerStrict($item);
                                if($bind->validate()){
                                    $result=$result&&$bind->insert();
                                }
                            }
                        }
                    }
                }
            }
            
            $transaction->commit();
        }catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
        }catch(\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }
        $this->trigger(static::EVENT_AFTER_SAVE_LIKE_ITEM);
        Event::trigger(static::className(), static::EVENT_AFTER_SAVE_LIKE_ITEM, new ItemEventMessage(['obj'=>$this]));

        return $result;
    }
    
    /**
     * Delete item, and binded elements
     * 
     * @throws \Exception
     * @throws \Throwable
     * @return boolean
     */
    abstract public function deleteLikeItem();
    
    /**********************************************************************/
    /** Load validate rules**/
    /**********************************************************************/
    
    /**
     * 
     * {@inheritDoc}
     * @see \yii\base\Model::validate()
     */
    public function validateLikeItem()
    {
        $result=true;
        $result=$result&&$this->validate();
        foreach ($this->extensions as $extension){
            $result=$result&&$extension->validate();
        }
        return $result;
    }
    
    /**
     * Load data to item and extensions
     * @param [] $data
     * @param null|string $formName
     */
    public function loadLikeItem($data,$formName=null)
    {
        $this->load($data,$formName);
        foreach ($this->extensions as $extension){
            $extension->load($data,$formName);
        }
    }
    
    
    /**
     * Truncate item table and delete its extensions items.
     *
     * @throws \Exception
     * @throws \Throwable
     * @return number
     */
    public static function truncateLikeItems()
    {
        $i=0;
        $db=Yii::$app->db;
        $transaction=$db->beginTransaction();
        try{
            $query=static::find();
            
            foreach ($query->each(10) as $item){
                $i++;
                $item->deleteLikeItem();
            }
            
            $transaction->commit();
        }catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
        }catch(\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }
        return $i;
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
            [["active","create_date_time","change_date_time"],"required"],
            [["active","create_date_time","change_date_time","sort"],"string"]
        ];
        $rules=ArrayHelper::merge($rules, $new_rules);
        return $rules;
    }
    
    /**
     * Return array of errors.
     * 
     * @return []
     */
    public function getAllErrors()
    {
        $errors=[];
        $errors=ArrayHelper::merge($errors, $this->getErrorSummary(true));
        foreach ($this->extensions as $extension){
            $errors=ArrayHelper::merge($errors, $extension->getErrorSummary(true));
        }
        return $errors;
    }
    
    /**
     * 
     * @return string
     */
    public static function tableName()
    {
        return Inflector::camel2id(StringHelper::basename(get_called_class()), '_');
    }
    
    /**
     * Return route for item select
     * 
     * @return string
     */
    public static function selectListRoute()
    {
        return "";
    }
    
    /**********************************************************************/
    /** Ierarhi **/
    /**********************************************************************/
    
    /**
     * Return entity section item
     *
     * @return AbstractSection|null
     */
    abstract public function getParentSection();
    
    /**********************************************************************/
    /** Extensions **/
    /**********************************************************************/
    
    /**
     * Init bind property array
     *
     * If current item is new, binds will be created by Yii::createObject($class).
     * If current item exists, binds will be created by invoking class::findByItem($item).
     * @throws \Exception
     */
    protected function initExtensions()
    {
        try{
            $extensions=$this->extensions();
            if($this->isNewRecord){                
                $val=null;
                foreach ($extensions as $key=>$val){
                    if(!Str::isString($val)){
                        throw new \InvalidArgumentException('Param $val is not string type.');
                    }
                    if(!Cls::isSubClassOf($val, ActiveRecord::class)){
                        throw new \InvalidArgumentException('Param $val is not '.ActiveRecord::class.' type.');
                    }
                    $this->extensions[$key]=Yii::createObject(["class"=>$val,"master_item"=>$this,"extension_name"=>$key]);
                }
            }else{
                foreach ($extensions as $key=>$val){
                    $extension=$val::findByItem($this,$key);
                    if(Vrbl::isNull($extension)){
                        throw new \InvalidArgumentException('Variable $extension is null.');
                    }
                    $this->extensions[$key]=$extension;
                }
            }
        }catch(\Exception $e){
            throw $e;
        }catch(\Throwable $e){
            throw $e;
        }
    }
    
    /**********************************************************************/
    /** Binders **/
    /**********************************************************************/
    
    protected function initBinders()
    {
        try{
            $binders=$this->binders();
            foreach ($binders as $binder_name=>$binder_cls){
                
                if(!Cls::isSubClassOf($binder_cls, AbstractBinder::class)){
                    throw new \InvalidArgumentException('Variable $binder_cls is not '.AbstractBinder::class.' type.');
                }
                $this->binders[$binder_name]=$binder_cls;
            }
        }catch(\Exception $e){
            throw $e;
        }catch(\Throwable $e){
            throw $e;
        }
    }
    
    /**********************************************************************/
    /** Init and set **/
    /**********************************************************************/
    
    /**
     * Init properties $create_date_time, $change_date_time by passed value.
     * 
     * If $date_time is null - set properties to current time.
     * 
     * @param bool isNewRecord
     * @param \DateTime $date_time
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    public function initCreateAndChangeDateTime(\DateTime $date_time=null)
    {
        if(Vrbl::isNull($date_time)){
            $date_time=new \DateTime();
        }
        if($this->isNewRecord){
           
            $this->create_date_time=$date_time->format(\DateTime::ATOM);
            $this->change_date_time=$date_time->format(\DateTime::ATOM);
        }else{
            //$date_time=new \DateTime();
            $this->change_date_time=$date_time->format(\DateTime::ATOM);
        }
        return $this;
    }
    
   
    
    /**
     * Set property $active to 'Y' value.
     * 
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    public function enableActive()
    {
        $this->active='Y';
        return $this;
    }
    
    /**
     * Set property $active to 'N' value.
     * 
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem
     */
    public function disableActive()
    {
        $this->active='N';
        return $this;
    }

    
    
}