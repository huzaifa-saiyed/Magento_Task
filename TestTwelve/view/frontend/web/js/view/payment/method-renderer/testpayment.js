define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Kitchen_TestTwelve/payment/testpayment'
            },
            /** Returns send check to info */
            getMailingAddress: function() {
            return window.checkoutConfig.payment.testpayment.mailingAddress;
            },
            /** Returns payable to info */
            /*getPayableTo: function() {
            return window.checkoutConfig.payment.checkmo.payableTo;
            }*/
        });
    }
);