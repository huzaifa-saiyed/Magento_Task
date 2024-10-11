<?php

namespace Kitchen\Gallery\Model\ResourceModel;

class Gallery extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('kitchen_gallery', 'entity_id');
    }
}
