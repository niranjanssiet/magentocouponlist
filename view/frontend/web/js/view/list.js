/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'uiComponent',
    'jquery',
    'couponListPopup',
    'getCouponList',
    'applyCoupon',
    'mage/translate'
], function (Component, $, couponListPopup, getCouponList, applyCoupon, $t) {
    'use strict';
    return Component.extend({
        modalWindow: null,

        defaults:{
            couponList: []
        },

        initialize: function () {
            this._super();
            this.getList();
        },

        getList: function ()
        {
            var self = this;
            var couponList = getCouponList();
            couponList.then(
                function(success) {
                    self.couponList(success);
                    $('body').trigger('processStop');
                }
            );
        },

        applycoupon: function (data, event) {
            return applyCoupon(data.code);
        },

        initObservable: function () {
            this._super().observe(['couponList']);
            return this;
        },

        setModalElement: function (element) {
            if (couponListPopup.modalWindow == null) {
                couponListPopup.createPopUp(element);
            }
        }
    });
});
