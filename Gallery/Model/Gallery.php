<?php

namespace Kitchen\Gallery\Model;

class Gallery extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init(\Kitchen\Gallery\Model\ResourceModel\Gallery::class);
    }
}
