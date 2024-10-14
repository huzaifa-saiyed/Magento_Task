<?php
namespace Kitchen365\CategoryStock\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }
    
    public function getStockStatus($_product, $sku, $cartqty)
    {
        $status = $this->scopeConfig->getValue('cataloginventory/item_options/custom_stock_field', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $statusArray = json_decode($status, true);
        foreach ($statusArray as $statusData) {
            if ($cartqty <= $statusData['max'] && $cartqty >= $statusData['min']) {   
                return $statusData['title'];
            }
        }
    }
}