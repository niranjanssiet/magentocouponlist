<?php

declare(strict_types=1);

namespace Magento\CouponList\Model;

use Magento\CouponList\Api\CouponListManagementInterface;
use Magento\CouponList\Api\ValidateCouponInterface;
use Magento\CouponList\Model\Exception\InvalidCouponException;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\SalesRule\Api\CouponRepositoryInterface;
use Magento\SalesRule\Api\Data\RuleInterface;
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
        $ruleList = $this->ruleRepository->getList($this->searchCriteriaBuilder->create());
        foreach ($ruleList->getItems() as $rule) {
            try {
                $websiteId = $this->getWebsiteId($websiteCode);
                $this->validateCouponInterface->execute($rule, $customerId, $websiteId);
                $couponCode = $this->getCouponCodeFromRule($rule);
                if($couponCode) {
                    $list[] = [Coupon::KEY_CODE => $couponCode, Rule::KEY_NAME => $rule->getName()];
                }
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

    /**
     * @param RuleInterface $rule
     * @return string|void|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getCouponCodeFromRule(RuleInterface $rule)
    {
        $this->searchCriteriaBuilder->addFilter(Coupon::KEY_RULE_ID, $rule->getRuleId());
        $couponList = $this->couponRepository->getList($this->searchCriteriaBuilder->create());
        foreach ($couponList->getItems() as $item) {
            return $item->getCode();
        }
    }
}
