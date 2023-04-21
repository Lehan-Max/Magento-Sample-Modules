<?php
namespace Codilar\ContactUs\Controller\Adminhtml\Contactus;

use Codilar\ContactUs\Model\ContactUsFactory;
use Codilar\ContactUs\Model\ResourceModel\ContactUs as ContactUsResource;
use Codilar\ContactUs\Model\ResourceModel\Contactus\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var ContactUsFactory
     */
    private ContactUsFactory $contactUsFactory;
    /**
     * @var ContactUsResource
     */
    private ContactUsResource $contactUsResource;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ContactUsFactory $contactUsFactory
     * @param ContactUsResource $contactUsResource
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ContactUsFactory $contactUsFactory,
        ContactUsResource $contactUsResource
    ) {
        $this->filter = $filter;
        parent::__construct($context);
        $this->contactUsFactory = $contactUsFactory;
        $this->contactUsResource = $contactUsResource;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute action
     *
     * @return Redirect
     * @throws LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $contact) {
            /** @var \Codilar\ContactUs\Model\ContactUs $model */
            $model = $this->contactUsFactory->create();
            $this->contactUsResource->load($model, $contact->getContactId())->delete($model);
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('contactus/contactus/index');
    }
}
