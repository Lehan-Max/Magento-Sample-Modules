<?php
namespace Codilar\ContactUs\Api\Data;

interface ContactusInterface
{
    const CONTACT_ID = 'contact_id';
    const NAME = 'name';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const SUBJECT = 'subject';
    const MESSAGE = 'message';

    /**
     * @param $value
     * @return void
     */
    public function setContactId($value);

    /**
     * @param $value
     * @return void
     */
    public function setName($value);

    /**
     * @param $value
     * @return void
     */
    public function setEmail($value);

    /**
     * @param $value
     * @return void
     */
    public function setPhone($value);
    /**
     * @param $value
     * @return void
     */
    public function setSubject($value);
    /**
     * @param $value
     * @return void
     */
    public function setMessage($value);

    /**
     * @return int
     */
    public function getContactId();

    /**
     * @return String
     */
    public function getName();

    /**
     * @return String
     */
    public function getEmail();

    /**
     * @return String
     */
    public function getPhone();
    /**
     * @return String
     */
    public function getSubject();
    /**
     * @return String
     */
    public function getMessage();
}
