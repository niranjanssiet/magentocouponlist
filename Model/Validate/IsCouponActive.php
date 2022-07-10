<?php

declare(strict_types=1);

namespace Magento\CouponList\Model\Validate;

use Magento\CouponList\Api\ValidateCouponInterface;
use Magento\CouponList\Model\Exception\InvalidCouponException;
use Magento\SalesRule\Api\Data\RuleInterface;

class IsCouponActive implements ValidateCouponInterface
{
    public function execute(RuleInterface $rule, $customerId, $websiteId)
    {
        if(!$rule->getIsActive()) {
            throw new InvalidCouponException(__('Coupon is not active'));
        }
    }
}
