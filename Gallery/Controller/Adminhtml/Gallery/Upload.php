<?php
 
namespace Kitchen\Gallery\Controller\Adminhtml\Gallery;
 
use Magento\Framework\Controller\ResultFactory;
 
class Upload extends \Magento\Backend\App\Action
{
 
    /**
     * @var \Kitchen\Gallery\Model\ImageUploader
     */
    public $imageUploader;
 
    /**
     * Upload constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Kitchen\News\Model\ImageUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Kitchen\Gallery\Model\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }
 
    /**
     * @return mixed
     */
    public function _isAllowed() {
        return $this->_authorization->isAllowed('Kitchen_Gallery::gallery_grid');
    }
 
    /**
     * @return mixed
     */
    public function execute() {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('image');
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}