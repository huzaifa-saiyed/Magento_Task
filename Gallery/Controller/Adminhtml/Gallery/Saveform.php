<?php
 
namespace Kitchen\Gallery\Controller\Adminhtml\Gallery;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Kitchen\Gallery\Model\GalleryFactory;
 
class Saveform extends Action
{
    protected $galleryFactory;
 
    public function __construct(
        Context $context,
        GalleryFactory $galleryFactory
    ) {
        $this->galleryFactory = $galleryFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $varOne = $this->getRequest()->getPostValue();
        if (!$varOne) {
            $this->messageManager->addErrorMessage(__('Invalid data. Please try again.'));
            $this->_redirect('gallery/gallery/index');
        } else {
            try {
                if (!empty($varOne['entity_id'])) {
                    $varModel = $this->galleryFactory->create()->load($varOne['entity_id']);
                    $this->messageManager->addSuccessMessage(__('Data has been updated.'));
                } else {
                    $varModel = $this->galleryFactory->create();
                    $this->messageManager->addSuccessMessage(__('Data has been saved.'));
                }

                if (isset($varOne['p_gallery'])) {
                    $varModel->setData('p_gallery', $varOne['p_gallery']);
                }

                $varModel->setTitle($varOne['title']);
                $varModel->setDescription($varOne['description']);
                $varModel->setSortOrder($varOne['sort_order']);       
                $varModel->setIsActive($varOne['is_active']);       

                if (!empty($varOne['image'][0]['name'])) {
                    $ImageName = $varOne['image'][0]['name'];
                    $varModel->setImage($ImageName);
                }

                $varModel->save();
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the user data.'));
            }
        }
 
        return $resultRedirect->setPath('gallery/gallery/index');
    }

} 