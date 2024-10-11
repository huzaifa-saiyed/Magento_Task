<?php

namespace Kitchen\TestTwelve\Model;

class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYMENT_METHOD_CUSTOM_INVOICE_CODE = 'testpayment';
    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_CUSTOM_INVOICE_CODE;
}
