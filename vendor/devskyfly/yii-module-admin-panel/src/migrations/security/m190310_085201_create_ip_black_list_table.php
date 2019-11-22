<?php
use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\AbstractMigrationHelper;

class m190310_085201_create_ip_black_list_table extends AbstractMigrationHelper
{
    public $table='ip_black_list';
    
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable($this->table, $this->getFieldsDefinition());
    }
    
    /**
     * {@inheritdoc}
     */
    public function down()
    {
        //echo "m181126_071444_init_ip_black_list_table cannot be reverted.\n";
        $this->dropTable($this->table);
        return true;
    }
    
    public function getFieldsDefinition()
    {
        return [
            'id'=>$this->primaryKey(11),
            'ip'=>$this->string(255)->notNull()->unique(),
            //'code'=>$this->string(255)->unique(),
            'active'=>"ENUM('Y','N') NOT NULL",
            'sort'=>$this->integer(11),
            'create_date_time'=>$this->dateTime(),
            'change_date_time'=>$this->dateTime(),
            '_section__id'=>$this->integer(11)
        ];
    }
}