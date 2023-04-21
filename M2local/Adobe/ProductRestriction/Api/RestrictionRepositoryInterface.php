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
namespace Adobe\ProductRestriction\Api;

/**
 * Interface of Product Restriction Repository class.
 */
interface RestrictionRepositoryInterface
{
    /**
     * Save Product Restriction object
     *
     * @param \Adobe\ProductRestriction\Api\Data\RestrictionInterface $restriction
     *
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function save(\Adobe\ProductRestriction\Api\Data\RestrictionInterface $restriction): void;

    /**
     * Retrieve Product Restriction object by IDCouldNotSaveException
     *
     * @param int $restrictionId
     *
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $restrictionId): \Adobe\ProductRestriction\Api\Data\RestrictionInterface;

    /**
     * Retrieve Product Restriction object by product SKU
     *
     * @param int $sku
     *
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBySku(int $sku): \Adobe\ProductRestriction\Api\Data\RestrictionInterface;

    /**
     * Retrieve list of Product Restriction objects
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria):
                        \Adobe\ProductRestriction\Api\Data\RestrictionSearchResultsInterface;

    /**
     * Delete Product Restriction object
     *
     * @param \Adobe\ProductRestriction\Api\Data\RestrictionInterface $entity
     *
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Adobe\ProductRestriction\Api\Data\RestrictionInterface $entity): void;

    /**
     * Delete Product Restriction by ID
     *
     * @param int $id
     *
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $id): void;

    /**
     * @return \Adobe\ProductRestriction\Model\Restriction
     */
    public function create();
}
