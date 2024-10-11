<?php
namespace Kitchen\Gallery\Model;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\App\RequestInterface;

use Kitchen\Gallery\Model\ResourceModel\Gallery\CollectionFactory;

class IsParent implements OptionSourceInterface
{
    protected $collectionFactory;
    protected $request;

    public function __construct(
        CollectionFactory $collectionFactory,
        RequestInterface $request
    ){
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
    }

    public function toOptionArray()
    {
        $options = [];
        $collection = $this->collectionFactory->create();
        $dataItem = $this->request->getParam('entity_id');
        foreach ($collection as $gallery) {
            if($gallery->getEntityId() != $dataItem) {
                $options[] = [
                    'value' => $gallery->getEntityId(),
                    'label' => $gallery->getTitle()
                ];                
            }
        }
        return $options;
    }
}
