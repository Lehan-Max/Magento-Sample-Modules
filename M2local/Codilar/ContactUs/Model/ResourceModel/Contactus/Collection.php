<?php

namespace Codilar\ContactUs\Model\ResourceModel\Contactus;

use Codilar\ContactUs\Model\ContactUs as Model;
use Codilar\ContactUs\Model\ResourceModel\ContactUs as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = "contact_id";

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
