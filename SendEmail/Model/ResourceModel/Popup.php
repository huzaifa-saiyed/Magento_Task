<?php

namespace Kitchen\SendEmail\Model\ResourceModel;

class Popup extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('kitchen_popup', 'entity_id');
    }
}
