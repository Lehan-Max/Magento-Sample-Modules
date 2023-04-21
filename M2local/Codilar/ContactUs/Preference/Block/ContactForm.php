<?php

namespace Codilar\ContactUs\Preference\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ContactForm extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param Template\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Returns action url for contact form
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('contact/index/post', ['_secure' => true]);
    }

    public function getSubjectConf()
    {
        $subject = $this->scopeConfig->getValue(
            'codilar_contactus/general/subject',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return explode(',', $subject);
    }
}
