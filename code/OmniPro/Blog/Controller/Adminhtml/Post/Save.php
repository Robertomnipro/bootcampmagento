<?php
namespace OmniPro\Blog\Controller\Adminhtml\Post;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Save extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'OmniPro_Blog::save';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Psr\Log\LoggerInterface
     */

    protected $_logger;

     /**
     * @param \OmniPro\Prueba\Api\BlogRepositoryInterface
     */
    protected $_blogRepository;
    
    /**
     * @param \OmniPro\Prueba\Api\Data\BlogInterfaceFactory
     */
    protected $_blogInterfaceFactory;


    /**
     * @param \Magento\Framework\App\Request\DataPersistorInterface
     */
    private $_dataPersistor;

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

    public function execute()
    {
        $data = $this->getRequest()->getPostValue()["post"];
    
        $this->_logger->debug('postValue  '.json_encode( $data));
        
        /**
         * @var \OmniPro\Blog\Model\Blog $blog
         */
        $blog = $this->_blogInterfaceFactory->create();
        $id =  $this->getRequest()->getParam('id'); //TODO: getById requset
        if($data){
            if(empty($id)){
                try {
                    $blog = $this->_blogRepository->getById($id);

                } catch (NoSuchEntityException $e) {
                   
                }              
            }
            $blog->setTitle($data['title'] ?? '');
            $blog->setEmail($data['email'] ?? '');
            $blog->setContent($data['content'] ?? '');
            $blog->setImg($data['image'] ?? '');

            try {     
                $this->_blogRepository->save($blog);
                $this->messageManager->addSuccessMessage(__("El blog ha sido creado exitosamente"));
                //TODO: datapersistor
            } catch (LocalizedException $e) {

            } catch(\Exception $e){

            }  
        }
       

        
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
