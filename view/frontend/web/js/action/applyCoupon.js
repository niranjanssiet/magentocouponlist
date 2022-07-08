define([
    'jquery',
    'mage/url',
    'mage/storage',
    'Magento_SalesRule/js/action/set-coupon-code',
    'Magento_SalesRule/js/model/coupon',
    'couponListPopup'
], function ($, url, storage, setCouponCodeAction, coupon, couponListPopup) {
    'use strict';

    var couponCodeElement = '#coupon_code';
    var couponForm = '#discount-coupon-form';
    var removeCouponElement = '#remove-coupon';

    return function (couponCode){
        var hash = window.location.hash
        /** Checkout Page **/
        if(hash == '#payment') {
            if($('.payment-option-content').is(':visible') == false){
                $('#block-discount-heading').trigger('click');
            }
            coupon.setCouponCode(couponCode);
            setCouponCodeAction(couponCode, coupon.getIsApplied());
            couponListPopup.closeModal();
        }
        /** Cart Page **/
        else {
            $(removeCouponElement).remove();
            $(couponCodeElement).removeAttr('disabled');
            $(couponCodeElement).val(couponCode);
            $(couponForm).trigger('submit');
        }
    };
});
