<?php

namespace Kitchen\SendEmail\Model;

class Popup extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init(\Kitchen\SendEmail\Model\ResourceModel\Popup::class);
    }
}
