<?php

namespace Kitchen\Gallery\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface; 
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Kitchen\Gallery\Model\ImageUploader; 
 
class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
 
    protected $storeManager;

    private $urlBuilder; 

    /** 

     * @param ContextInterface $context 

     * @param UiComponentFactory $uiComponentFactory 

     * @param \Magento\Catalog\Helper\Image $imageHelper 

     * @param \Magento\Framework\UrlInterface $urlBuilder 

     * @param array $components 

     * @param array $data 

     */ 
 
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder; 
    }
 
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $mediaUrl = $this->getMediaUrl();
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $imageUrl = $mediaUrl . ImageUploader::BASE_TMP_PATH.$item['image'];
                $item[$fieldName . '_src'] = $imageUrl;
                $item[$fieldName . '_alt'] = $item['image'];
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl( 

                    'gallery/gallery/indexform', 

                    ['entity_id' => $item['entity_id']] 

                ); 
                $item[$fieldName . '_orig_src'] = $imageUrl;

            }
        }
 
        return $dataSource;
    }

    public function getMediaUrl() 

    { 

        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA); 

    } 
}
