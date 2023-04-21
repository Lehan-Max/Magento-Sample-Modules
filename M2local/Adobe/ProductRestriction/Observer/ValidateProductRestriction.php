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

namespace Adobe\ProductRestriction\Observer;

use Adobe\ProductRestriction\Model\RestrictionValidatorInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Api\Data\CartInterface;

/**
 * The 'sales_quote_address_collect_totals_after' event observer class to validate Product Restriction.
 */
class ValidateProductRestriction implements ObserverInterface
{
    /**
     *
     * @var RestrictionValidatorInterface
     */
    private $restrictionValidator;

    /**
     * @param RestrictionValidatorInterface $restrictionValidator
     */
    public function __construct(
        RestrictionValidatorInterface $restrictionValidator
    ) {
        $this->restrictionValidator = $restrictionValidator;
    }

    /**
     * Validate Product Restriction
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var CartInterface $quote */
        $quote = $observer->getData('quote');
        if ($quote !== null) {
            $this->restrictionValidator->execute($quote);
        }
    }
}
