<?php

declare(strict_types=1);

namespace Magento\CouponList\Model;

use Magento\CouponList\Api\ValidateCouponInterface;
use Magento\SalesRule\Api\Data\CouponInterface;
use Magento\SalesRule\Api\Data\RuleInterface;

class ValidateCoupon implements ValidateCouponInterface
{
    /**
     * @var array
     */
    private $validatorPool;

    public function __construct($validatorPool = [])
    {
        $this->validatorPool = $validatorPool;
    }

    /**
     * @param CouponInterface $coupon
     * @param RuleInterface $rule
     * @return mixed|void
     */
    public function execute(RuleInterface $rule, $customerId, $websiteId)
    {
        /** @var ValidateCouponInterface $validator */
        foreach ($this->validatorPool as $validator)
        {
            $validator->execute($rule, $customerId, $websiteId);
        }
    }
}
