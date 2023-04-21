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
use Adobe\ProductRestriction\Api\Data\RestrictionInterfaceFactory;
use Adobe\ProductRestriction\Api\Data\RestrictionSearchResultsInterface;
use Adobe\ProductRestriction\Api\Data\RestrictionSearchResultsInterfaceFactory;
use Adobe\ProductRestriction\Api\RestrictionRepositoryInterface;
use Adobe\ProductRestriction\Model\ResourceModel\Restriction as RestrictionResource;
use Adobe\ProductRestriction\Model\ResourceModel\Restriction\Collection;
use Adobe\ProductRestriction\Model\ResourceModel\Restriction\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\EntityManager\HydratorPool;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Product Restriction Repository class.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RestrictionRepository implements RestrictionRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var RestrictionSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var RestrictionInterfaceFactory
     */
    private $entityFactory;

    /**
     * @var RestrictionResource
     */
    private $resource;

    /**
     * @var RestrictionFactory
     */
    private $modelFactory;

    /**
     * @var HydratorPool
     */
    private $hydratorPool;

    private RestrictionFactory $restrictionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param RestrictionSearchResultsInterfaceFactory $searchResultsFactory
     * @param RestrictionInterfaceFactory $entityFactory
     * @param ResourceModel\Restriction $resource
     * @param RestrictionFactory $modelFactory
     * @param HydratorPool $hydratorPool
     * @param RestrictionFactory $restrictionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        RestrictionSearchResultsInterfaceFactory $searchResultsFactory,
        RestrictionInterfaceFactory $entityFactory,
        RestrictionResource $resource,
        RestrictionFactory $modelFactory,
        HydratorPool $hydratorPool,
        RestrictionFactory $restrictionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->entityFactory = $entityFactory;
        $this->resource = $resource;
        $this->modelFactory = $modelFactory;
        $this->hydratorPool = $hydratorPool;
        $this->restrictionFactory = $restrictionFactory;
    }

    /**
     * Save Product Restriction object
     *
     * @param \Adobe\ProductRestriction\Api\Data\RestrictionInterface $entity
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Adobe\ProductRestriction\Api\Data\RestrictionInterface $entity): void
    {
        try {

            $this->resource->save($entity);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('The "%1" Product Restriction was unable to be saved.', $entity->getRestrictionId())
            );
        }
    }

    /**
     * Retrieve Product Restriction object by ID
     *
     * @param int $id
     *
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get(int $id): \Adobe\ProductRestriction\Api\Data\RestrictionInterface
    {
        /** @var Restriction $model */
        $model = $this->modelFactory->create();
        $this->resource->load($model, $id, RestrictionInterface::ID);

        if (null === $model->getRestrictionId()) {
            throw new NoSuchEntityException(
                __('The Product Restriction with the "%1" ID wasn\'t found. Verify the ID and try again.', $id)
            );
        }

        /** @var RestrictionInterface $entity */
        $entity = $this->entityFactory->create();

        $hydrator = $this->hydratorPool->getHydrator(RestrictionInterface::class);
        $hydrator->hydrate($entity, $model->getData());

        return $entity;
    }

    /**
     * Retrieve Product Restriction object by product SKU
     *
     * @param int $sku
     *
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBySku(int $sku): \Adobe\ProductRestriction\Api\Data\RestrictionInterface
    {
        /** @var Restriction $model */
        $model = $this->modelFactory->create();
        $this->resource->load($model, $sku, RestrictionInterface::SKU);

        if (null === $model->getRestrictionId()) {
            throw new NoSuchEntityException(
                __('Product Restriction with the SKU "%1" does not exist.', $sku)
            );
        }

        /** @var RestrictionInterface $entity */
        $entity = $this->entityFactory->create();

        $hydrator = $this->hydratorPool->getHydrator(RestrictionInterface::class);
        $hydrator->hydrate($entity, $model->getData());

        return $entity;
    }

    /**
     * Retrieve list of Product Restriction objects
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria):
                        \Adobe\ProductRestriction\Api\Data\RestrictionSearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $entities = [];
        /** @var Restriction $model */
        foreach ($collection->getItems() as $model) {
            /** @var RestrictionInterface $entity */
            $entity = $this->entityFactory->create();

            $hydrator = $this->hydratorPool->getHydrator(RestrictionInterface::class);
            $hydrator->hydrate($entity, $model->getData());
            $entities[] = $entity;
        }

        /** @var RestrictionSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($entities);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete Product Restriction object
     *
     * @param \Adobe\ProductRestriction\Api\Data\RestrictionInterface $entity
     *
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\Adobe\ProductRestriction\Api\Data\RestrictionInterface $entity): void
    {
        $this->deleteById($entity->getRestrictionId());
    }

    /**
     * Delete Product Restriction by ID
     *
     * @param int $id
     *
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $id): void
    {
        try {
            /** @var Restriction $model */
            $model = $this->modelFactory->create();
            $this->resource->load($model, $id, RestrictionInterface::ID);

            $this->resource->delete($model);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(
                __('The Product Restriction with ID "%1" couldn\'t be removed.', $id)
            );
        }
    }

    /**
     * @return \Adobe\ProductRestriction\Model\Restriction
     */
    public function create()
    {
        return $this->restrictionFactory->create();
    }
}
