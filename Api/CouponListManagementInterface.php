<?php

namespace Magento\CouponList\Api;

/**
 * Interface CouponListManagementInterface
 *
 * @api
 * @since 1.0.0
 */
interface CouponListManagementInterface
{
    /**
     * @param int $customerId
     * @param string $websiteCode
     * @return mixed
     */
    public function getList($customerId, $websiteCode): array;

    /**
     * @param string $websiteCode
     * @return mixed
     */
    public function getGuestList($websiteCode): array;
}
