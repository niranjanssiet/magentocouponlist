<?php

declare(strict_types=1);

namespace Magento\CouponList\Model\Validate;

use Magento\CouponList\Api\ValidateCouponInterface;
use Magento\CouponList\Model\Exception\InvalidCouponException;
use Magento\Customer\Model\Session;
use Magento\SalesRule\Api\Data\RuleInterface;

class CouponAssignedToCustomerGroup implements ValidateCouponInterface
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function execute(RuleInterface $rule, $customerId, $websiteId)
    {
        if(!in_array($this->getCustomerGroupId(), $rule->getCustomerGroupIds())) {
            throw new InvalidCouponException(__('Coupon is not assigned to Customer Group'));
        }
    }

    private function getCustomerGroupId()
    {
        return $this->session->getCustomerGroupId();
    }
}
