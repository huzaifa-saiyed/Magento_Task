<?php

namespace Kitchen\CartRules\Observer;

class AddtionalPriceRuleObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Execute observer.
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // Magento\SalesRule\Model\Rule\Condition getNewChildSelectOptions() 81
        $additional = $observer->getAdditional();

        $additionalConditions = (array) $additional->getConditions();

        $conditions = array_merge_recursive(
            $additionalConditions, 
            [
                [
                    'value' => [
                        [
                            'value' => \Kitchen\CartRules\Model\Rule\Condition\AddtionalRules::class,
                            'label' => __('Cart Price Custom Field')
                        ]
                    ],
                    'label' => __('Addtional Condition')
                ]
            ]
        );

        if ($additionalConditions) {
            $conditions = array_merge_recursive($conditions, $additionalConditions);
        }

        $additional->setConditions($conditions);
        return $this;
    }
}
