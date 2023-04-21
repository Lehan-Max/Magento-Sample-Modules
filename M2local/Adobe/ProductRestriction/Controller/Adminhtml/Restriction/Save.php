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

namespace Adobe\ProductRestriction\Controller\Adminhtml\Restriction;

use Adobe\ProductRestriction\Api\RestrictionRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Insert New product restriction
 */
class Save extends Action
{
    /**
     * @var RestrictionRepositoryInterface
     */
    private $restrictionRepository;

    /**
     * Save constructor.
     * @param Context $context
     * @param RestrictionRepositoryInterface $restrictionRepository
     */
    public function __construct(
        Context $context,
        RestrictionRepositoryInterface $restrictionRepository
    ) {
        parent::__construct($context);
        $this->restrictionRepository = $restrictionRepository;
    }

    /**
     * Execute method for save product restriction
     *
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        try {
            $post = $this->getRequest()->getParams();
            $productRestriction = $this->restrictionRepository->create();
            $productRestriction->setSku($post['sku']);
            $productRestriction->setCountryId($post['country_id']);
            $productRestriction->setRegionCode($post['region_code']);
            $this->restrictionRepository->save($productRestriction);
            $this->messageManager->addSuccessMessage('Product Restriction Saved Successfully!!!');
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage('There is an error wile saving Product Restriction!!');
        }
        $this->_redirect('adobe_restriction/restriction/index');
    }
}
