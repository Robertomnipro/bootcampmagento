<?php
namespace OmniPro\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use OmniPro\Blog\Model\Blog;

class Create extends Action
{
   

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        $blogDatas = $this->getRequest()->getParam('post');
        if(is_array($blogDatas)) {
            $contact = $this->_objectManager->create(Blog::class);
            $contact->setData($blogDatas)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index');
        }
    }
}
