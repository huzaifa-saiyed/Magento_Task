<?php
namespace Kitchen\Gallery\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Kitchen\Gallery\Model\ResourceModel\Gallery\CollectionFactory as GalleryCollectionFactory;

class GalleryName extends Column
{
    protected $galleryCollectionFactory;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        GalleryCollectionFactory $galleryCollectionFactory,
        array $components = [],
        array $data = []
    ) {
        $this->galleryCollectionFactory = $galleryCollectionFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $parentGalleryId = $item['p_gallery'];
                $galleryCollection = $this->galleryCollectionFactory->create();
                $parentGallery = $galleryCollection->addFieldToFilter('entity_id', $parentGalleryId)->getFirstItem();
                $item[$this->getData('name')] = $parentGallery->getTitle();
            }
        }
        return $dataSource;
    }
}
