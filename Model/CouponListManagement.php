<?php

declare(strict_types=1);

namespace Magento\CouponList\Model;

use Magento\CouponList\Api\CouponListManagementInterface;
use Magento\CouponList\Api\ValidateCouponInterface;
use Magento\CouponList\Model\Exception\InvalidCouponException;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\SalesRule\Api\CouponRepositoryInterface;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magento\SalesRule\Model\Coupon;
use Magento\SalesRule\Model\Data\Rule;
use Magento\Store\Api\WebsiteRepositoryInterface;

class CouponListManagement implements CouponListManagementInterface
{
    /**
     * @var CouponRepositoryInterface
     */
    private $couponRepository;
    /**
     * @var RuleRepositoryInterface
     */
    private $ruleRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var ValidateCouponInterface
     */
    private $validateCouponInterface;
    /**
     * @var WebsiteRepositoryInterface
     */
    private $websiteRepository;

    public function __construct(
        CouponRepositoryInterface  $couponRepository,
        RuleRepositoryInterface $ruleRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ValidateCouponInterface $validateCouponInterface,
        WebsiteRepositoryInterface $websiteRepository
    )
    {
        $this->couponRepository = $couponRepository;
        $this->ruleRepository = $ruleRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->validateCouponInterface = $validateCouponInterface;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @inheirtDoc
     */
    public function getList($customerId, $websiteCode): array
    {
        $list = [];
        $couponList = $this->couponRepository->getList($this->searchCriteriaBuilder->create());
        foreach ($couponList->getItems() as $coupon) {
            try {
                $rule = $this->ruleRepository->getById($coupon->getRuleId());
                $websiteId = $this->getWebsiteId($websiteCode);
                $this->validateCouponInterface->execute($rule, $customerId, $websiteId);
                $list[] = [Coupon::KEY_CODE => $coupon->getCode(), Rule::KEY_NAME => $rule->getName()];
            }catch (InvalidCouponException|NoSuchEntityException $exception) {
                continue;
            }
        }
        return $list;
    }

    /**
     * @inheirtDoc
     */

    public function getGuestList($websiteCode): array
    {
        return $this->getList(0, $websiteCode);
    }

    /**
     * @param $websiteCode
     * @return int
     * @throws NoSuchEntityException
     */
    private function getWebsiteId($websiteCode)
    {
        return $this->websiteRepository->get($websiteCode)->getId();
    }
}
