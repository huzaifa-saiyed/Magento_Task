<?php

namespace Kitchen\CartRules\Model\Rule\Condition;

class AddtionalRules extends \Magento\Rule\Model\Condition\AbstractCondition
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @param \Magento\Rule\Model\Condition\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * 
     *
     * @return $this
     */
    public function loadAttributeOptions()
    {
        $attributes = [
            'cart_price_custom_field' => __('Cart Price Custom Field Model')
        ];

        $this->setAttributeOption($attributes);

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getInputType()
    {
        return 'numeric';
    }

    /**
     *
     * @return string
     */
    public function getValueElementType()
    {
        return 'text';
    }

    /**
     *
     * @param \Magento\Framework\Model\AbstractModel $model
     * @return bool
     */
    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        $subTotal = $this->checkoutSession->getQuote()->getSubtotal();
        $discountPrice = $this->checkoutSession->getQuote()->getSubtotalWithDiscount();


        $cartPrice = $this->getRule()->getCartPriceCustomField();

        // get column value in table
        if($cartPrice <= 0) {
            return false;
        }

        // if(($subTotal < $cartPrice) || ($subTotal > $cartPrice)) {
        //     return 0;
        // }

        if($this->getValue()) {
            switch ($this->getOperator()) {
                case '==':
                    return $this->getRule()->getCartPriceCustomField() == $this->getValue();
                case '!=':
                    return $this->getRule()->getCartPriceCustomField() != $this->getValue();
                case '>':
                    return $this->getRule()->getCartPriceCustomField() > $this->getValue();
                case '<':
                    return $this->getRule()->getCartPriceCustomField() < $this->getValue();
                case '>=':
                    return $this->getRule()->getCartPriceCustomField() >= $this->getValue();
                case '<=':
                    return $this->getRule()->getCartPriceCustomField() <= $this->getValue();
                default:
                    return false;
            }
        }
    }
}
