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
namespace Adobe\ProductRestriction\Model;

use Adobe\ProductRestriction\Api\Data\RestrictionInterface;
use Magento\Framework\Model\AbstractModel;
use Adobe\ProductRestriction\Model\ResourceModel\Restriction as ResourceModel;

/**
 * Product Restriction base model class.
 */
class Restriction extends AbstractModel implements RestrictionInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inerhitDoc
     * @return int|null
     */
    public function getRestrictionId(): ?int
    {
        return $this->getData(self::ID);
    }

    /**
     * @param int $restrictionId
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionInterface
     */
    public function setRestrictionId(int $restrictionId): RestrictionInterface
    {
        return $this->setData(self::ID, $restrictionId);
    }

    /**
     * @inerhitDoc
     */
    public function getSku(): string
    {
        return $this->getData(self::SKU);
    }

    /**
     * @param string $sku
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionInterface
     */
    public function setSku(string $sku): RestrictionInterface
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @inerhitDoc
     */
    public function getRegionCode(): string
    {
        return $this->getData(self::REGION_CODE);
    }

    /**
     * @param string $regionCode
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionInterface
     */
    public function setRegionCode(string $regionCode): RestrictionInterface
    {
        return $this->setData(self::REGION_CODE, $regionCode);
    }
    /**
     * @inerhitDoc
     */
    public function getCountryId(): string
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * @param string $countryId
     * @return \Adobe\ProductRestriction\Api\Data\RestrictionInterface
     */
    public function setCountryId(string $countryId): RestrictionInterface
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }
}
