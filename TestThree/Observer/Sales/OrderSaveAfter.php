<?php

namespace Kitchen\TestThree\Observer\Sales;

class OrderSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
    /*** @var \Magento\Catalog\Model\ProductRepository*/
    protected $productRepository;
    protected $logger;

    public function __construct
    (
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) 
    {
        $this->logger = $logger;
        $this->productRepository = $productRepository;
    }

    /*** Execute observer** 
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
    */
    public function execute(\Magento\Framework\Event\Observer $observer) 
    {
        $order= $observer->getData('order');
        $order->setCustomFilter(1);
        $order->save();
    }
}