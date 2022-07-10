<?php

namespace Magento\CouponList\Api;

use Magento\CouponList\Model\Exception\InvalidCouponException;
use Magento\SalesRule\Api\Data\RuleInterface;

/**
 * Interface ValidateCouponInterface
 *
 * @since 1.0.0
 */
interface ValidateCouponInterface
{
    /**
     * @param $customerId
     * @param $websiteId
     * @param RuleInterface $rule
     * @throws InvalidCouponException
     * @return mixed
     */
    public function execute(RuleInterface $rule, $customerId, $websiteId);
}
