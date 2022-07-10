# Magento CouponList

This repository has CouponList module


> **Note:** Please take a necessary backup before install this module.


# Installation:

The Coupon List module can be installed with [Composer](https://getcomposer.org/). 

There are two ways to install the module in  Magento. Composer way (**Recommended**) and the other one is manual installation.

# Pre-Condition for installation using Composer:

   Install and setup Composer in your environment.                                                  
   Download link: [https://getcomposer.org/Composer-Setup.exe]


# Install a module using Composer either any of the below methods:

**Method 1:**

```

Open command prompt and navigate to the Magento root directory where the composer.json file is placed. Run the below commands.
  
composer config repositories.couponlist vcs https://github.com/niranjanssiet/magentocouponlist
  
composer config -g github-oauth.github.com < Get GitHub oauth token >
  
composer require magento/module-couponlist:versionnumber


After composer installation, open command prompt and navigate to the Magento root  directory where the composer.json file is placed.
         
Run **composer install**, if composer is being executed for the first time, else **composer update**.

Now the module will install under the **/vendor/magento/module-couponlist/** folder as per the composer.json configuration.

```
          
# How to enable the Module in Magento:

```
        
Open Command prompt and navigate to the Magento root directory and run the below commands,   

php bin/magento module:status 
            

Enable the module, upgrade schema and flush cache using the commands below.
  
php bin/magento module:enable Magento_CouponList
             
php bin/magento setup:upgrade 
            
php bin/magento cache:flush

```
		
# How it works

![How it works](https://i.ibb.co/zfd0mNH/couponlist.gif)

