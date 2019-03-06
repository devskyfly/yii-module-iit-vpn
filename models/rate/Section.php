<?php
namespace devskyfly\yiiModuleIitVpn\models\rate;

use devskyfly\yiiModuleIitVpn\models\common\AbstractSection;

class Section extends AbstractSection
{
    protected static function entityCls()
    {
        return Rate::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-vpn/rates/section-select-list";
    }
}