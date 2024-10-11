<?php
namespace Kitchen\Carts\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Checkout\Model\Cart;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Quote\Api\CartManagementInterface;

class Add extends Action
{
    protected $resultJsonFactory;
    protected $cart;
    protected $quoteFactory;
    protected $quoteRepository;
    protected $storeManager;
    protected $cartManagementInterface;
    protected $customerSession;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        Cart $cart,
        QuoteFactory $quoteFactory,
        CartRepositoryInterface $quoteRepository,
        StoreManagerInterface $storeManager,
        CustomerSession $customerSession,
        CartManagementInterface $cartManagementInterface,
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->cartManagementInterface = $cartManagementInterface;
        $this->cart = $cart;
        $this->quoteFactory = $quoteFactory;
        $this->quoteRepository = $quoteRepository;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        $productId = $this->getRequest()->getParam('product_id');
        $qty = $this->getRequest()->getParam('qty');

        try {
            // Disable existing quote
            $quote = $this->cart->getQuote();
            if ($quote->getId()) {
                $quote->setIsActive(false);
                $this->quoteRepository->save($quote);
            }

            // Create new quote
            // $newQuote = $this->quoteFactory->create();
            // $newQuote->setStoreId($this->storeManager->getStore()->getId());
            // $newQuote->setIsActive(true);
            // $this->quoteRepository->save($newQuote);

            // Add product to new quote
            // $product = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($productId);
            // $newQuote->addProduct($productId, $qty);
            // $this->quoteRepository->save($newQuote);

            // $this->cart->setQuote($newQuote);
            // $this->cart->save();

            $customer = $this->customerSession->getCustomerDataObject();
            $customerId = $customer->getId();
            
           
            $quoteId = $this->cartManagementInterface->createEmptyCartForCustomer($customerId);
          
 
            $quote = $this->quoteRepository->getActive($quoteId);
            
          
            $this->cart->addProduct($productId,$qty);
            $this->cart->save($quote);

            $result->setData(['success' => true, 'message' => __('Product added to cart.')]);
        } catch (\Exception $e) {
            $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }

        return $result;
    }
}
