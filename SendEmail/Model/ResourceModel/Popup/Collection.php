<?php

namespace Kitchen\SendEmail\Model\ResourceModel\Popup;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idName = 'entity_id';
    protected function _construct()
    {
        $this->_init(
            \Kitchen\SendEmail\Model\Popup::class,
            \Kitchen\SendEmail\Model\ResourceModel\Popup::class
        );
    }
}
