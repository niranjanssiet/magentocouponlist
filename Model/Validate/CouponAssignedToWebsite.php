<?php

declare(strict_types=1);

namespace Magento\CouponList\Model\Validate;

use Magento\CouponList\Api\ValidateCouponInterface;
use Magento\CouponList\Model\Exception\InvalidCouponException;
use Magento\SalesRule\Api\Data\RuleInterface;

class CouponAssignedToWebsite implements ValidateCouponInterface
{
    public function execute(RuleInterface $rule, $customerId, $websiteId)
    {
        if(!in_array($websiteId, $rule->getWebsiteIds())) {
            throw new InvalidCouponException(__('Coupon is not assigned to website'));
        }
    }
}
