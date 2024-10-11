<?php

namespace Kitchen\MetaTitle\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\App\RequestInterface;

class CategorySaveAfter implements ObserverInterface
{
    protected $registry;
    protected $pageConfig;
    protected $request;

    public function __construct(
        Registry $registry,
        PageConfig $pageConfig,
        RequestInterface $request
    ) {
        $this->registry = $registry;
        $this->pageConfig = $pageConfig;
        $this->request = $request;
    }

    public function execute(Observer $observer)
    {
        if ($this->request->getFullActionName() == 'catalog_category_view') {
            $category = $this->registry->registry('current_category');
            if ($category && $category->getId()) {
                $indexFollow = $category->getData('index_follow');
                if ($indexFollow) {
                    $this->pageConfig->setRobots('INDEX,FOLLOW');
                } else {
                    $this->pageConfig->setRobots('NOINDEX,NOFOLLOW');
                }
            }
        }
    }
}
