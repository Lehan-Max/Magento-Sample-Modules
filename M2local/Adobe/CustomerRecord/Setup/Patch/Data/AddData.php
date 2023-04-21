<?php
/**
 * Copyright © Lehan, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Adobe\CustomerRecord\Setup\Patch\Data;

use Adobe\CustomerRecord\Model\CustomerRecordFactory;
use Exception;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class AddData
 * @package Adobe\CustomerRecord\Setup\Patch\Data
 */
class AddData implements DataPatchInterface
{
    private CustomerRecordFactory $customerRecordFactory;

    /**
     * AddData constructor.
     * @param CustomerRecordFactory $customerRecordFactory
     */
    public function __construct(
        CustomerRecordFactory $customerRecordFactory
    ) {

        $this->customerRecordFactory = $customerRecordFactory;
    }

    /**
     * @return AddData|void
     * @throws Exception
     */
    public function apply()
    {
        $sampleData = [
            [
                'name' => "Lehan Max",
                'email' => 'lehanmax@gmail.com',
                'phone' => 7894561237
            ],
            [
                'name' => "Test User",
                'email' => 'testuser@gmail.com',
                'phone' => 7894561236
            ]
        ];
        foreach ($sampleData as $data) {
            $this->customerRecordFactory->create()->setData($data)->save();
        }
    }

    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAliases()
    {
        return [];
    }
}
