<?php
/**
 * Copyright © Lehan, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Adobe\ExtensionAttribute\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

/**
 * Class ProductRepositoryInterface
 * @package Adobe\ExtensionAttribute\Plugin
 */
class ProductRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * ProductRepositoryInterface constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * set extension attribute is_featured to get() function
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function afterGet(\Magento\Catalog\Api\ProductRepositoryInterface $subject, ProductInterface $product)
    {
        if ($product->getExtensionAttributes() && $product->getExtensionAttributes()->getIsFeatured()) {
            return $product;
        }
        $isFeatured = $this->getIsFeatured($product->getId());
        $extensionAttribute = $product->getExtensionAttributes()->setIsfeatured($isFeatured);
        $product->setExtensionAttributes($extensionAttribute);
        return $product;
    }

    /**
     * Get is_featured value from product
     * @param $productId
     * @return array|mixed|null
     */
    private function getIsFeatured($productId)
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter('entity_id', ['eq' => $productId])
            ->getFirstItem()->getData('is_featured');
    }

    /**
     * set is_featured extension attribute to getList()
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param \Magento\Catalog\Api\Data\ProductSearchResultsInterface $searchCriteria
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function afterGetList(
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Magento\Catalog\Api\Data\ProductSearchResultsInterface $searchCriteria
    ) : \Magento\Catalog\Api\Data\ProductSearchResultsInterface {
        $products = [];
        foreach ($searchCriteria->getItems() as $entity) {
            /** Get Current Extension Attributes from Product */
            $extensionAttributes = $entity->getExtensionAttributes();
            $isFeatured = $this->getIsFeatured($entity->getId());
            $extensionAttributes->setIsFeatured($isFeatured);
            $entity->setExtensionAttributes($extensionAttributes);
            $products[] = $entity;
        }
        $searchCriteria->setItems($products);
        return $searchCriteria;
    }
}
