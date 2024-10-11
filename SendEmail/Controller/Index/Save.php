<?php

namespace Kitchen\SendEmail\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kitchen\SendEmail\Model\PopupFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Controller\Result\JsonFactory;

class Save extends Action
{
    protected $_popupFactory;
    protected $_jsonFactory;
    protected $_scopeConfig;
    protected $_transportBuilder;

    public function __construct(
        Context $context,
        PopupFactory $popupFactory,
        JsonFactory $jsonFactory,
        ScopeConfigInterface $scopeConfig,
        TransportBuilder $transportBuilder
    ) {
        $this->_popupFactory = $popupFactory;
        $this->_jsonFactory = $jsonFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->_jsonFactory->create();
        
        try {
            $jsonData = $this->getRequest()->getContent();
            $data = json_decode($jsonData, true);
            
           
            $name = $data['name'] ?? '';
            $email = $data['email'] ?? '';
            $gender = $data['gender'] ?? '';
            $image = $data['file'] ?? '';
            $status = $data['status'] ?? '';
            
          
            $popupModel = $this->_popupFactory->create();
            $popupModel->setName($name);
            $popupModel->setEmail($email);
            $popupModel->setGender($gender);
            $popupModel->setImage($image);
            $popupModel->setStatus($status);

            $popupModel->save();

            $this->sendEmail($name, $email, $gender, $image, $status);
            return $result->setData([
                'success' => true,
                'data' => $popupModel->getData()
            ]);
        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function sendEmail($name, $email, $gender, $image, $status)
    {
        $templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID);

        $senderName= $this->_scopeConfig->getValue('section_email/group_email/from_names', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $fromEmail= $this->_scopeConfig->getValue('section_email/group_email/from_emails', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $template= $this->_scopeConfig->getValue('section_email/group_email/emails_template', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $transport = $this->_transportBuilder->setTemplateIdentifier($template)
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars([
                    'name' => $name,
                    'email' => $email,
                    'gender' => $gender,
                    'image' => $image,
                    'status' => $status,
                ])
                ->setFrom([
                    'name' => $senderName,
                    'email' => $fromEmail
                ])
                ->addTo([$email])
                ->getTransport();
            $transport->sendMessage();
    }
}
