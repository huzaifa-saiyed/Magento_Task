<?php

namespace Kitchen\Gallery\Model\ResourceModel\Gallery;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idName = 'entity_id';
    protected function _construct()
    {
        $this->_init(
            \Kitchen\Gallery\Model\Gallery::class,
            \Kitchen\Gallery\Model\ResourceModel\Gallery::class
        );
    }
}
