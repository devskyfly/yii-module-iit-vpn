<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

class EntityEditor extends AbstractItemEditor
{
    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\widgets\contentPanel\AbstractItemEditor::init()
     */
    public function init()
    {
        parent::init();
        $this->view='entity-editor';
    }
}