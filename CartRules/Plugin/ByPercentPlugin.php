<?php
 
namespace Kitchen\CartRules\Plugin;

use Magento\SalesRule\Model\Rule\Action\Discount\ByPercent;
 
class ByPercentPlugin
{ 
    /**
     * Calculate discount by percent
     *
     * @param ByPercent $subject
     * @param \Magento\SalesRule\Model\Rule $rule
     * @param \Magento\Quote\Model\Quote\Item\AbstractItem $item
     * @param float $qty
     * @return Data
     */
    public function aroundCalculate(ByPercent $subject, $proceed, $rule, $item, $qty)
     {
        $discountData = $proceed($rule, $item, $qty);

        $cartPriceCustomField = $rule->getCartPriceCustomField();

        if($cartPriceCustomField) {

            $quote = $item->getQuote();
            $currentTotalDiscount = 0;

            foreach($quote->getAllItems() as $quoteItem) {
                $currentTotalDiscount = $currentTotalDiscount + $quoteItem->getDiscountAmount();
            }
            $remainingDiscount = max(0, $cartPriceCustomField - $currentTotalDiscount);

            $getAmount = min($discountData->getAmount(), $remainingDiscount);
            $getBaseAmount = min($discountData->getBaseAmount(), $remainingDiscount);
            $getOriginalAmount = min($discountData->getOriginalAmount(), $remainingDiscount);
            $getBaseOriginalAmount = min($discountData->getBaseOriginalAmount(), $remainingDiscount);
        }

            $discountData->setAmount($getAmount);
            $discountData->setBaseAmount($getBaseAmount);
            $discountData->setOriginalAmount($getOriginalAmount);
            $discountData->setBaseOriginalAmount($getBaseOriginalAmount);

        return $discountData;
    }
}
 