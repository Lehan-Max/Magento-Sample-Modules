<?php
namespace Codilar\ContactUs\Model;

use Codilar\ContactUs\Api\Data\ContactusInterface;
use Codilar\ContactUs\Model\ResourceModel\Contactus as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class ContactUs extends AbstractModel implements ContactusInterface
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function setContactId($value)
    {
        $this->setData(self::CONTACT_ID, $value);
    }

    public function setName($value)
    {
        $this->setData(self::NAME, $value);
    }

    public function setEmail($value)
    {
        $this->setData(self::EMAIL, $value);
    }

    public function setPhone($value)
    {
        $this->setData(self::PHONE, $value);
    }

    public function setSubject($value)
    {
        $this->setData(self::SUBJECT, $value);
    }

    public function setMessage($value)
    {
        $this->setData(self::MESSAGE, $value);
    }

    public function getContactId()
    {
        return $this->getData(self::CONTACT_ID);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    public function getSubject()
    {
        return $this->getData(self::SUBJECT);
    }

    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }
}
