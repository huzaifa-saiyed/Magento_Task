<?php
namespace Kitchen\TestTwelve\Observer;
 
use Magento\Framework\Event\ObserverInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\SessionFactory;
use Magento\Customer\Model\CustomerFactory;

class PaymentMethod implements ObserverInterface
{
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    protected $checkoutSession;

    protected $customerFactory;

    protected $sessionFactory;

    
    /**
     * PaymentMethod constructor.
     *
     * @param CustomerSession $customerSession
     */
    public function __construct(
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
        CustomerFactory $customerFactory,
        SessionFactory $sessionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->customerFactory = $customerFactory;
        $this->sessionFactory = $sessionFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $methodInstance = $observer->getMethodInstance();
        $result = $observer->getResult();
        
        if ($methodInstance->getCode() == 'testpayment') {
            $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
            $allowedCustomerGroups = $methodInstance->getConfigData('customer_group');

            if ($allowedCustomerGroups && !in_array($customerGroupId, explode(',', $allowedCustomerGroups))) {
                $result->setData('is_available', false);
                return;
            }
        }

        $result->setData('is_available', true);
    }
}
