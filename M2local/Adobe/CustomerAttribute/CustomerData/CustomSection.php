<?php
declare(strict_types=1);

/**
 * Copyright © Lehan, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Adobe\CustomerAttribute\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * returns array with key custom data and value of customer custom attribute
 */
class CustomSection implements SectionSourceInterface
{
    /**
     * @var CurrentCustomer
     */
    private CurrentCustomer $currentCustomer;
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * CustomSection constructor.
     * @param CurrentCustomer $currentCustomer
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getSectionData(): array
    {
        $customerId = $this->currentCustomer->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);
        $customerCountry = $customer->getCustomAttribute('customer_country');
        return [
            'customdata' => $customerCountry->getValue()
        ];
    }
}
