<?php
/**
 * Copyright © Lehan, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Adobe\CustomerRecord\Model;

use Adobe\CustomerRecord\Model\ResourceModel\CustomerRecord as ResourceModel;
use Magento\Framework\Model\AbstractModel;

/**
 * Class CustomerRecord
 * @package Adobe\CustomerRecord\Model
 */
class CustomerRecord extends AbstractModel
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
