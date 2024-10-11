<?php
namespace Kitchen\Uzaifa\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CurrentTime extends Template
{
    protected $scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getCurrentTime()
    {
        if ($this->scopeConfig->getValue('custom_section/custom_group/show_current_time')) {
            return date('Y-m-d H:i:s');
        }
        return false;
    }
}
