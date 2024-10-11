<?php

namespace Kitchen\TestThree\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $productRepository;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);
        $this->productRepository = $productRepository;
    }

    public function getProductBySku($sku)
    {
        try {
            $product = $this->productRepository->get($sku);
            return $product;
        } catch (\Exception $e) {
            return null;
        }
    }
}
