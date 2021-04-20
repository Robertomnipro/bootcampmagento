<?php
namespace OmniPro\Blog\Controller\Adminhtml\Post;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'OmniPro_Blog::save';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    protected $_logger;


    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
       \Psr\Log\LoggerInterface $logger,
       \OmniPro\Blog\Api\Data\BlogInterfaceFactory $blogInterfaceFactory,
       \OmniPro\Blog\Api\BlogRepositoryInterface $blogRepository
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_blogRepository = $blogRepository;
        $this->_blogInterfaceFactory = $blogInterfaceFactory;
        // $this->_dataPersistor = $dataPersistor;
        $this->_logger = $logger;
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue()["post"];
    
        $this->_logger->debug('postValue  '.json_encode( $data));
        
        /**
         * @var \OmniPro\Blog\Model\Blog $blog
         */
        $blog = $this->_blogInterfaceFactory->create();
        $blog->setTitle($data['title'] ?? '');
        $blog->setEmail($data['email'] ?? '');
        $blog->setContent($data['content'] ?? '');
        $blog->setImg($data['image'] ?? '');
        $this->_blogRepository->save($blog);

        
        return $this->_redirect('*/*/');
    }

    /**
     * Is the user allowed to view the page.
    *
    * @return bool
    */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
