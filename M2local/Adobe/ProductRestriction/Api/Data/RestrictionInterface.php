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

namespace Adobe\ProductRestriction\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface of Product Restriction base model class.
 */
interface RestrictionInterface extends ExtensibleDataInterface
{
    public const ID = 'restriction_id';
    public const SKU = 'sku';
    public const COUNTRY_ID = 'country_id';
    public const REGION_CODE = 'region_code';

    /**
     * @return int|null
     */
    public function getRestrictionId(): ?int;

    /**
     * @param int $restrictionId
     * @return $this
     */
    public function setRestrictionId(int $restrictionId): RestrictionInterface;

    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku): RestrictionInterface;

    /**
     * @return string
     */
    public function getCountryId(): string;

    /**
     * @param string $countryId
     * @return $this
     */
    public function setCountryId(string $countryId): RestrictionInterface;

    /**
     * @return string
     */
    public function getRegionCode(): string;

    /**
     * @param string $regionCode
     * @return $this
     */
    public function setRegionCode(string $regionCode): RestrictionInterface;
}
