define([
    'jquery',
    'mage/url',
    'mage/storage'
], function ($, url, storage) {
    'use strict';

    return function (){
        var isLoggedIn = window.isCustomerLoggedIn;
        var websiteCode = window.checkoutConfig.websiteCode;
        var serviceURL;
        if(isLoggedIn) {
            var customerId = window.customerData.id;
            serviceURL = 'rest/V1/couponList/customerId/'+customerId +'/websiteCode/'+websiteCode;
        }
        else {
            serviceURL = 'rest/V1/guest-couponList/websiteCode/'+websiteCode;
        }
        return new window.Promise(function (resolve) {
            storage.get(url.build(serviceURL)).done(function (response) {
                resolve(response);
            });
        });
    };
});
