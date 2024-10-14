<?php
 
namespace Kitchen365\CategoryStock\Block\Adminhtml\Form\Field;
 
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
 
class FrontOptions extends AbstractFieldArray
{ 
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
 
    protected function _prepareToRender()
    {
 
        $this->addColumn(
            'title',
            [
                'label' => __('Stock Status'),
                'id' => 'title',
                'class' => 'daterecuring',
                'style' => 'width:200px'
            ]
        );
 
        $this->addColumn(
            'min',
            [
                'label' => __('Min. Value'),
                'class' => 'required-entry',
                'style' => 'width:200px',
            ]
        );

        $this->addColumn(
            'max',
            [
                'label' => __('Max. Value'),
                'class' => 'required-entry',
                'style' => 'width:200px',
            ]
        );
 
        $this->_addAfter = false;
        $this->_addButtonLabel = __('MoreAdd');
    }
 
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];
        $row->setData('option_extra_attrs', $options);
    }
}
 