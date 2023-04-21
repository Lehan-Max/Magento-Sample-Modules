<?php
/**
 * Copyright © Lehan, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Adobe\CustomerRecord\Model\ResourceModel\BankDetails;

use Adobe\CustomerRecord\Model\CustomerRecord as Model;
use Adobe\CustomerRecord\Model\ResourceModel\CustomerRecord as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Adobe\CustomerRecord\Model\ResourceModel\BankDetails
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = "id";
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
