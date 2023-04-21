<?php

namespace Codilar\ContactUs\Api;

use Codilar\ContactUs\Api\Data\ContactusInterface;
use Codilar\ContactUs\Model\Contactus as Model;
use Codilar\ContactUs\Model\ResourceModel\Contactus\Collection as Collection;
use Magento\Framework\Exception\NoSuchEntityException;

interface ContactusRepositoryInterface
{
    /**
     * @param int $id
     * @return ContactusInterface
     * @throws NoSuchEntityException
     */
    public function getDataBYId($id);

    /**
     * @param Model $model
     * @return Model
     */
    public function save(Model $model);

    /**
     * @param Model $model
     * @return Model
     */
    public function delete(Model $model);

    /**
     * @param $value
     * @param null $field
     * @return Model
     */
    public function load($value, $field = null);

    /**
     * @return Model $model
     */
    public function create();

    /**
     * @param $id
     * @return Model
     */
    public function deleteById($id);

    /**
     * @return Collection
     */
    public function getCollection();
}
