<?php
namespace devskyfly\yiiModuleAdminPanel\console\search;

use yii\helpers\BaseConsole;
use yii\console\Controller;
use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleAdminPanel\models\search\ElasticSearchProvider;
use devskyfly\yiiModuleAdminPanel\models\search\Indexer;
use devskyfly\yiiModuleAdminPanel\Module;

abstract class AbstractIndexerController extends Controller
{
    /**
     * 
     * @var \devskyfly\yiiModuleAdminPanel\models\search\ElasticSearchProvider
     */
    protected $elastic_provider=null;
    
    public function init()
    {
        parent::init();
        
        $module=Module::getInstance();
        
        if(Vrbl::isNull($module)){
            throw \InvalidArgumentException('Variable $module is null.');
        }
        $search_settings=$module->search_settings;
        
        $this->elastic_provider=new ElasticSearchProvider();
        
        if(isset($search_settings['index_settings'])
            &&Arr::isArray($search_settings['index_settings'])){
                $this->elastic_provider->index_settings=$search_settings['index_settings'];
        }
        
        if(isset($search_settings['type_mappings'])
            &&Arr::isArray($search_settings['type_mappings'])){
                $this->elastic_provider->type_mappings=$search_settings['type_mappings'];
        }
    }
    
    /**********************************************************************/
    /** Index actions **/
    /**********************************************************************/
    
    public function actionCreateIndex()
    {
        try{
            $response=$this->elastic_provider->createIndex();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    }
    
    /* public function actionCreateIndexPutSettings()
    {
        try{
            $response=$this->elastic_provider->closeIndex();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
            $response=$this->elastic_provider->putSettings();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
            $response=$this->elastic_provider->openIndex();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    } */
    
    
    public function actionUpdateIndex()
    {
        try{
            $indexer=new Indexer();
            $handler=$this->dataProviderHandler();
            $indexer->index($handler);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
             return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return ;
    }
    
    public function actionDropIndex()
    {
        try{
            $response=$this->elastic_provider->dropIndex();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    }
    
    /* public function actionOpenIndex()
    {
        try{
            $response=$this->elastic_provider->openIndex();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    } */
    
    /* public function actionCloseIndex()
    {
        try{
            $response=$this->elastic_provider->closeIndex();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    } */
    /**********************************************************************/
    /** Settings, mappings**/
    /**********************************************************************/
    
   /*  public function actionGetIndexMapping()
    {
        try{
            $response=$this->elastic_provider->getIndexMapping();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    } */
    
    public function actionPutTypeMappings()
    {
        try{
            $response=$this->elastic_provider->putTypeMappings();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    }
    
    public function actionPutIndexSettings()
    {
        try{
            $response=$this->elastic_provider->putIndexSettings();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    }
    
    public function actionOpenIndex()
    {
        try{
            $response=$this->elastic_provider->openIndex();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    }
    
    public function actionCloseIndex()
    {
        try{
            $response=$this->elastic_provider->closeIndex();
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    }
    
    /**********************************************************************/
    /** Search **/
    /**********************************************************************/
    
    public function actionSearch()
    {
        try{
            $str=BaseConsole::prompt('Insert search request:');
            $response=$this->elastic_provider->search($str);
            BaseConsole::stdout(print_r($response,true).PHP_EOL);
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        return 0;
    }
    
    /**********************************************************************/
    /** Abstract **/
    /**********************************************************************/
    
    /**
     * @return callable
     */
    abstract protected function dataProviderHandler();
}

