<?php
namespace Kitchen\Carts\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Quote\Model\QuoteManagement;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Quote\Model\Quote\AddressFactory;

class PlaceOrder extends Action
{
    protected $cartManagementInterface;
    protected $cartRepository;
    protected $storeManager;
    protected $resultRedirectFactory;
    protected $customerSession;
    protected $quoteManagement;
    protected $dataPersistor;
    protected $addressFactory;

    const SHIPPING_METHOD = 'flatrate_flatrate'; 
    const PAYMENT_METHOD = 'checkmo'; 

    public function __construct(
        Context $context,
        CartManagementInterface $cartManagementInterface,
        CartRepositoryInterface $cartRepository,
        StoreManagerInterface $storeManager,
        RedirectFactory $resultRedirectFactory,
        CustomerSession $customerSession,
        QuoteManagement $quoteManagement,
        DataPersistorInterface $dataPersistor,
        AddressFactory $addressFactory
    ) {
        $this->cartManagementInterface = $cartManagementInterface;
        $this->cartRepository = $cartRepository;
        $this->storeManager = $storeManager;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->customerSession = $customerSession;
        $this->quoteManagement = $quoteManagement;
        $this->dataPersistor = $dataPersistor;
        $this->addressFactory = $addressFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $customer = $this->customerSession->getCustomerDataObject();
            $customerId = $customer->getId();

            $quote = $this->cartRepository->getActiveForCustomer($customerId);

            if (!$quote->getId()) {
                throw new LocalizedException(__('No active quote found.'));
            }

            $store = $this->storeManager->getStore();
            $quote->setStore($store);
            $quote->setStoreId($store->getId());

            $quote->assignCustomer($customer);

            $billingAddressData = $this->getRequest()->getParam('billing');
            $shippingAddressData = $this->getRequest()->getParam('shipping');
            $sameAsShipping = $this->getRequest()->getParam('same_as_shipping');
            $shippingMethod = $this->getRequest()->getParam('shipping_method');
            $paymentMethod = $this->getRequest()->getParam('payment_method');


            $billingAddress = $this->addressFactory->create();
            $billingAddress->addData($billingAddressData);
            $billingAddress->setCustomerAddressId(null);
            $billingAddress->setQuote($quote);
            $billingAddress->setStoreId($store->getId());

            $shippingAddress = $this->addressFactory->create();
            $shippingAddress->addData($shippingAddressData);
            $shippingAddress->setCustomerAddressId(null);
            $shippingAddress->setQuote($quote);
            $shippingAddress->setStoreId($store->getId());

            if ($sameAsShipping) {
                $billingAddress->setSameAsShipping(true);
            }

            $quote->setBillingAddress($billingAddress);
            $quote->setShippingAddress($shippingAddress);

            $shippingAddress->setCollectShippingRates(true)
                ->collectShippingRates()
                ->setShippingMethod(self::SHIPPING_METHOD);

            $quote->getShippingAddress()->setShippingMethod(self::SHIPPING_METHOD);
            $quote->getShippingAddress()->collectShippingRates();

            $quote->setPaymentMethod(self::PAYMENT_METHOD);
            $quote->setInventoryProcessed(false);

            $quote->getPayment()->importData(['method' => self::PAYMENT_METHOD]);

            $quote->collectTotals();
            $this->cartRepository->save($quote);

            $order = $this->quoteManagement->submit($quote);

            if ($order) {
                $this->messageManager->addSuccessMessage(__('Your order has been placed successfully.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('checkout/onepage/success');
            } else {
                throw new LocalizedException(__('There was a problem processing your order. Please try again.'));
            }

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('order_form_data', $this->getRequest()->getParams());
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('customcart/checkout/index');
        }
    }
}
?>
