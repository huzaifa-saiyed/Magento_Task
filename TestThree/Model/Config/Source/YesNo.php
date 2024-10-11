<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\TestThree\Model\Config\Source;


/**
 * @api
 * @since 100.0.2
 */
class YesNo implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => 'No'],
            ['value' => '1', 'label' => 'Yes']
        ];
        
        }
    }
