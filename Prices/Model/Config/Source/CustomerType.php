<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Kitchen\Prices\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;


/**
 * @api
 * @since 100.0.2
 */
class CustomerType extends AbstractSource
{
    /**
     * Options getter
     *
     * @return array
     */

    public function getAllOptions()
    {
        return [
            ['value' => 0, 'label' => __('Individual')],
            ['value' => 1, 'label' => __('Company')],
        ];
        
        }
    }
