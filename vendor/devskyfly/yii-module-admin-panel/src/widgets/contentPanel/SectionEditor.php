<?php
namespace devskyfly\yiiModuleAdminPanel\widgets\contentPanel;

class SectionEditor extends AbstractItemEditor
{
    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\widgets\contentPanel\AbstractItemEditor::init()
     */
    public function init()
    {
        parent::init();
        $this->view='section-editor';
    }
}