<?php

namespace Kitchen\Carts\Block;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;


class Index extends \Magento\Framework\View\Element\Template
{
    protected $countryCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CollectionFactory $countryCollectionFactory,

        
    ) {
        parent::__construct($context);
        $this->countryCollectionFactory = $countryCollectionFactory;


    }

    public function getParag() {
        echo "This is Block";
    }
    public function getCountryOptions()
    {
        $collection = $this->countryCollectionFactory->create()->loadByStore();
        $countries = [];
        foreach ($collection as $country) {
            $countries[] = [
                'value' => $country->getCountryId(),
                'label' => $country->getName()
            ];
        }
        return $countries;
    }
 
}