<?php
namespace OmniPro\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use OmniPro\Blog\Model\Blog;

class Create extends Action
{
    const ADMIN_RESOURCE = 'OmniPro_Prueba::new';

    const PAGE_TITLE = 'New Blog';

     /**
     * @param \Psr\Log\LoggerInterface
     */

    protected $_logger;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
       \Psr\Log\LoggerInterface $logger
       
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_logger = $logger;
        return parent::__construct($context);
    }


    /**
     * Edit A Contact Page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
    
        $this->_logger->debug('data  '.json_encode( $data));
       /** @var \Magento\Framework\View\Result\Page $resultPage */
       $resultPage = $this->_pageFactory->create();
       $resultPage->setActiveMenu(static::ADMIN_RESOURCE);
       $resultPage->addBreadcrumb(__(static::PAGE_TITLE), __(static::PAGE_TITLE));
       $resultPage->getConfig()->getTitle()->prepend(__(static::PAGE_TITLE));

       return $resultPage;
    }
}
