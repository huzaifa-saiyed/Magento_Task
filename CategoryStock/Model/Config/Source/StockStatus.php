<?php

namespace Kitchen365\CategoryStock\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\Config\ScopeConfigInterface;

class StockStatus extends AbstractSource
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [];
            
            // Fetch the serialized data from system configuration
            $values = $this->scopeConfig->getValue(
                'cataloginventory/item_options/custom_stock_field',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );

            if ($values) {
                // $values = unserialize($values); // Unserialize the data if it is serialized
                $statusArray = json_decode($values, true);

                foreach ($statusArray as $value) {
                    if (isset($value['title'])) {
                        $this->_options[] = [
                            'label' => $value['title'], // Use 'title' as the label
                            'value' => $value['title'], // Use 'title' as the value
                        ];
                    }
                }
            }
        }

        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = [];
        foreach ($this->getAllOptions() as $option) {
            $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }
}
