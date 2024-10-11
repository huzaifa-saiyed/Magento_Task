<?php

namespace Kitchen\Gallery\Model\Config\Source\Status;

use Kitchen\Gallery\Model\GalleryFactory;

/**
 * @api
 * @since 100.0.2
 */
class IsEnable implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */

    protected $customerFactory;

    public function __construct(
        GalleryFactory $galleryFactory
    ) {
        $this->galleryFactory = $galleryFactory;
    }

    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => 'No'],
            ['value' => '1', 'label' => 'Yes']
        ];
        
        }
    }
