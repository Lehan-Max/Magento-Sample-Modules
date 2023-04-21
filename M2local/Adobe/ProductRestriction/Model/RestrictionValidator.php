<?php
/*******************************************************************************
 * ADOBE CONFIDENTIAL
 * ___________________
 *
 * Copyright 2022 Adobe
 * All Rights Reserved.
 *
 * NOTICE: All information contained herein is, and remains
 * the property of Adobe and its suppliers, if any. The intellectual
 * and technical concepts contained herein are proprietary to Adobe
 * and its suppliers and are protected by all applicable intellectual
 * property laws, including trade secret and copyright laws.
 * Adobe permits you to use and modify this file
 * in accordance with the terms of the Adobe license agreement
 * accompanying it (see LICENSE_ADOBE_PS.txt).
 * If you have received this file from a source other than Adobe,
 * then your use, modification, or distribution of it
 * requires the prior written permission from Adobe.
 ******************************************************************************/
declare(strict_types=1);

namespace Adobe\ProductRestriction\Model;

use Adobe\ProductRestriction\Api\Data\RestrictionInterface;
use Adobe\ProductRestriction\Api\Data\RestrictionSearchResultsInterface;
use Adobe\ProductRestriction\Api\RestrictionRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Item as QuoteItem;

/**
 * Validates Quote Items for the product restrictions.
 */
class RestrictionValidator implements RestrictionValidatorInterface
{
    /**
     * @var RestrictionRepositoryInterface
     */
    private $restrictionRepository;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $criteriaBuilderFactory;

    /**
     * @param RestrictionRepositoryInterface $restrictionRepository
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param SearchCriteriaBuilderFactory $criteriaBuilderFactory
     */
    public function __construct(
        RestrictionRepositoryInterface $restrictionRepository,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        SearchCriteriaBuilderFactory $criteriaBuilderFactory
    ) {
        $this->restrictionRepository = $restrictionRepository;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->criteriaBuilderFactory = $criteriaBuilderFactory;
    }

    /**
     * Validates Quote Items for the product restrictions
     *
     * @param CartInterface $quote
     *
     * @return void
     */
    public function execute(
        CartInterface $quote
    ): void {
        /** @var Address $shippingAddress */
        $shippingAddress = $quote->getShippingAddress();
        if (empty($quote->getItems())
            || $shippingAddress->getCountryId() === null
        ) {
            return;
        }

        $searchCriteria = $this->compileSearchCriteria($quote);
        $searchResults = $this->restrictionRepository->getList($searchCriteria);

        if ($searchResults->getTotalCount() > 0) {
            $restrictionSkus = $this->collectRestrictionSkus($searchResults);
            /** @var QuoteItem $quoteItem */
            foreach ($quote->getItems() as $quoteItem) {
                if (in_array($quoteItem->getSku(), $restrictionSkus)) {
                    $this->addError(
                        $quote,
                        $quoteItem,
                        (string)__('The product with SKU "%1" is restricted.', $quoteItem->getSku())
                    );
                }
            }
        }
    }

    /**
     * Compiles search criteria to find related product restrictions
     *
     * @param CartInterface $quote
     *
     * @return SearchCriteriaInterface
     */
    private function compileSearchCriteria(
        CartInterface $quote
    ): SearchCriteriaInterface {
        $filterGroups = [];

        $quoteSkus = $this->collectQuoteSkus($quote);
        $filterSku = $this->filterBuilder
            ->setField(RestrictionInterface::SKU)
            ->setValue($quoteSkus)
            ->setConditionType('in')
            ->create();

        $filterGroups[] = $this->filterGroupBuilder
            ->addFilter($filterSku)
            ->create();

        /** @var Address $shippingAddress */
        $shippingAddress = $quote->getShippingAddress();

        $countryId = $shippingAddress->getCountryId() ?: 'US';
        $filterCountryId = $this->filterBuilder
            ->setField(RestrictionInterface::COUNTRY_ID)
            ->setValue($countryId)
            ->setConditionType('eq')
            ->create();

        $filterGroups[] = $this->filterGroupBuilder
            ->addFilter($filterCountryId)
            ->create();

        $regionCode = $shippingAddress->getRegionCode() ?: null;
        if (!empty($regionCode)) {
            $filterRegionCode = $this->filterBuilder
                ->setField(RestrictionInterface::REGION_CODE)
                ->setValue($regionCode)
                ->setConditionType('eq')
                ->create();

            $filterGroups[] = $this->filterGroupBuilder
                ->addFilter($filterRegionCode)
                ->create();
        }

        $criteriaBuilder = $this->criteriaBuilderFactory->create();

        $searchCriteria = $criteriaBuilder->create();
        $searchCriteria->setFilterGroups($filterGroups);
        return $searchCriteria;
    }

    /**
     * Collects SKUs for the quote items
     *
     * @param CartInterface $quote
     *
     * @return array
     */
    private function collectQuoteSkus(
        CartInterface $quote
    ): array {
        $data = [];
        /** @var QuoteItem $quoteItem */
        foreach ($quote->getItems() as $quoteItem) {
            $data[$quoteItem->getSku()] = $quoteItem->getSku();
        }
        return $data;
    }

    /**
     * Collects SKUs for the available product restrictions
     *
     * @param RestrictionSearchResultsInterface $searchResults
     *
     * @return array
     */
    private function collectRestrictionSkus(
        RestrictionSearchResultsInterface $searchResults
    ): array {
        $data = [];
        foreach ($searchResults->getItems() as $item) {
            $data[$item->getSku()] = $item->getSku();
        }
        return $data;
    }

    /**
     * Add Product Restriction Error to the Quote and Quote Item objects
     *
     * @param CartInterface $quote
     * @param CartItemInterface $quoteItem
     * @param string $errorMessage
     *
     * @return void
     */
    private function addError(
        CartInterface $quote,
        CartItemInterface $quoteItem,
        string $errorMessage
    ): void {
        $quoteItem->addErrorInfo(
            'Adobe_ProductRestriction',
            null,
            $errorMessage
        );

        $quote->addErrorInfo(
            'error',
            'Adobe_ProductRestriction',
            null,
            $errorMessage
        );
    }
}
