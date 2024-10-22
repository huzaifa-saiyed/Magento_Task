<?php
use Magento\Framework\App\Bootstrap;

require __DIR__ . '/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend'); 
 
$productRepository = $objectManager->get('Magento\Catalog\Api\ProductRepositoryInterface');
$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory')->create();
 
$productCollection->addFieldToFilter('type_id', 'simple')
                  ->addAttributeToFilter('has_options', 1); 
 
foreach ($productCollection as $product) {
    $product = $productRepository->getById($product->getId());  
 
    $options = $product->getOptions();
 
    foreach ($options as $option) {
        if ($option->getTitle() == 'Depth') { 
            $values = $option->getValues();
 
            foreach ($values as $value) {
                $depthValue = (int)$value->getTitle(); 
                 
                if ($depthValue > 14 && $depthValue < 21) { 
                    $value->delete();
                }
            }
            $option->save();
            break; 
        }
        $productRepository->save($product);
    }
}

echo "Script Run Successfully.\n";