<?php

namespace Kitchen\TestTwelve\Controller\Index;

use Magento\Framework\UrlInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class EmailSend extends \Magento\Framework\App\Action\Action
{
	protected $resultJsonFactory;
	protected $scopeConfig;
	protected $_pageFactory;
	protected $_url;
	protected $inlineTranslation;
	protected $_transportBuilder;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		JsonFactory $resultJsonFactory,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		UrlInterface $url,
		StateInterface $inlineTranslation,
		TransportBuilder $transportBuilder,
		ScopeConfigInterface $scopeConfig


	) {
		$this->_pageFactory = $pageFactory;
		$this->_url = $url;
		$this->inlineTranslation = $inlineTranslation;
		$this->_transportBuilder = $transportBuilder;
		$this->resultJsonFactory = $resultJsonFactory;
		$this->scopeConfig = $scopeConfig;


		return parent::__construct($context);
	}

	public function execute()
	{
		$jsonData = $this->getRequest()->getContent();
		$data = json_decode($jsonData, true);
		$email = '';


		$email = isset($data['email']) ? $data['email'] : '';
		$comment = isset($data['comment']) ? $data['comment'] : '';

		$template = $this->scopeConfig->getValue('email_section/email_group/email_template', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

		$fromEmail = $this->scopeConfig->getValue('email_section/email_group/from', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);


		$templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => 1);
		$templateVars = [
			'comment' => $comment,
		];

		$this->inlineTranslation->suspend();
		$transport = $this->_transportBuilder->setTemplateIdentifier($template)
			->setTemplateOptions($templateOptions)
			->setTemplateVars($templateVars)
			->setFrom([
				'name' => 'Kitchen365',
				'email' => $fromEmail
			])
			->addTo($email)
			->getTransport();
		$transport->sendMessage();
		$this->inlineTranslation->resume();
	}
}
