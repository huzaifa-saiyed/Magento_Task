<?php

namespace Kitchen\Gallery\Controller\Adminhtml\Gallery;
 
class Delete extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{ 
    protected $galleryFactory;
 
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Kitchen\Gallery\Model\GalleryFactory $galleryFactory,
    ) {
        parent::__construct($context);
        $this->galleryFactory = $galleryFactory;
    }
 
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        
        if ($id) {
            try {                
                $pageModel = $this->galleryFactory->create()->load($id);
                $pageModel->delete();
                
                $this->messageManager->addSuccessMessage(__('The data has been deleted.'));
            } catch (\Exception  $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a page to delete.'));
        $this->_redirect('gallery/Gallery/index');
    }
}
