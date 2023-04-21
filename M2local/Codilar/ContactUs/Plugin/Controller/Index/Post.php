<?php

namespace Codilar\ContactUs\Plugin\Controller\Index;

use Codilar\ContactUs\Api\ContactusRepositoryInterface;
use Codilar\ContactUs\Model\ContactUs;
use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Post extends \Magento\Contact\Controller\Index\Post
{
    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;
    /**
     * @var LoggerInterface|null
     */
    private ?LoggerInterface $logger;
    /**
     * @var MailInterface
     */
    private MailInterface $mail;
    /**
     * @var ContactusRepositoryInterface
     */
    private ContactusRepositoryInterface $contactusRepository;
    /**
     * @var ContactUs
     */
    private ContactUs $contactUs;

    /**
     * Post constructor.
     * @param Context $context
     * @param ConfigInterface $contactsConfig
     * @param MailInterface $mail
     * @param DataPersistorInterface $dataPersistor
     * @param LoggerInterface|null $logger
     * @param ContactusRepositoryInterface $contactusRepository
     * @param ContactUs $contactUs
     */
    public function __construct(
        Context $context,
        ConfigInterface $contactsConfig,
        MailInterface $mail,
        DataPersistorInterface $dataPersistor,
        LoggerInterface $logger = null,
        ContactusRepositoryInterface $contactusRepository,
        ContactUs $contactUs
    ) {
        parent::__construct($context, $contactsConfig, $mail, $dataPersistor, $logger);
        $this->dataPersistor = $dataPersistor;
        $this->logger = $logger;
        $this->mail = $mail;
        $this->contactusRepository = $contactusRepository;
        $this->contactUs = $contactUs;
    }

    /**
     * @param \Magento\Contact\Controller\Index\Post $subject
     * @param callable $proceed
     * @return Redirect
     */
    public function aroundExecute(
        \Magento\Contact\Controller\Index\Post $subject,
        callable $proceed
    ) {
        if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        try {
            $model = $this->contactUs;
            $this->getRequest()->getParam('name');
            $model->setName($this->getRequest()->getParam('name'));
            $model->setEmail($this->getRequest()->getParam('email'));
            $model->setPhone($this->getRequest()->getParam('telephone'));
            $model->setMessage($this->getRequest()->getParam('comment'));
            $model->setSubject($this->getRequest()->getParam('subject'));
            $this->contactusRepository->save($model);

            $this->sendEmail($this->validatedParams());
            $this->messageManager->addSuccessMessage(
                __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
            );
            $this->dataPersistor->clear('contact_us');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('contact_us', $this->getRequest()->getParams());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(
                __('An error occurred while processing your form. Please try again later.')
            );
            $this->dataPersistor->set('contact_us', $this->getRequest()->getParams());
        }
        return $this->resultRedirectFactory->create()->setPath('contact/index');
    }

    /**
     * @param array $post Post data from contact form
     * @return void
     */
    private function sendEmail($post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('name')) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }
        if (trim($request->getParam('comment')) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }
        if (false === \strpos($request->getParam('email'), '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }
        if (trim($request->getParam('hideit')) !== '') {
            throw new \Exception();
        }

        return $request->getParams();
    }
}
