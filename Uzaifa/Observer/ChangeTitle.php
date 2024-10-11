<?php
namespace Kitchen\Uzaifa\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ChangeTitle implements ObserverInterface
{
    protected $_pageConfig;

    public function __construct(
        \Magento\Framework\View\Page\Config $pageConfig
    ) {
        $this->_pageConfig = $pageConfig;
    }

    public function execute(Observer $observer)
    {
        $fullActionName = $observer->getData('full_action_name');

        if ($fullActionName == 'cms_index_index') {
            $this->_pageConfig->getTitle()->set(__('Welcome to Kitchen365'));
        }
    }
}
