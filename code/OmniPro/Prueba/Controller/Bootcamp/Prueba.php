<?php
namespace OmniPro\Prueba\Controller\Bootcamp;

use \Magento\Framework\Controller\ResultFactory;
use OmniPro\Prueba\Model\blog;

class Prueba extends \Magento\Framework\App\Action\Action
{
	
	/**
	 *	@var \Magento\Framework\View\Result\PageFactory
	 **/
	protected $_pageFactory;

	/**
	 *	@var \Magento\Store\Model\StoreManagerInterface
	 **/
	protected $_storeManger;
	
	
	/**
	 *	@var \OmniPro\Prueba\Model\PostFactory
	 **/
	
	protected $_postFactory;
	
	/**
	 *	@param \Magento\Framework\App\Action\Context
	 **/
	protected $_blogInterfaceFactory;
	
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\OmniPro\Prueba\Model\PostFactory $postFactory,
		\Magento\Store\Model\StoreManagerInterface $storeMaganger,
		\OmniPro\Prueba\Api\Data\BlogInterfaceFactory $blogInterfaceFactory
		)
		{
			$this->_pageFactory = $pageFactory;
			$this->_postFactory = $postFactory;
			$this -> _storeManger = $storeMaganger;
			$this-> _blogInterfaceFactory = $blogInterfaceFactory;
			return parent::__construct($context);
		}
		
		/**
		 *	@return \Magento\Framework\Controller\ResultInterface
		 **/

		public function execute()
		{
		// $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
		// $result ->setData([			
		// 	'error' => 'false',
		// 	'store' => $this->_storeManger->getStore('test_view_store')->getCode(),
		// ]);
		// // return $result;
		// $post = $this->_postFactory->create();
		// $collection = $post->getCollection();
		// // print_r($collection);
		// foreach($collection as $item){
		// 	echo "<pre>";
		// 	print_r($item->getData());
		// 	echo "</pre>";
		// }
		$params = $this->_request->getParams();
		/**
		 * @var \OmniPro\Prueba\Model\Blog $blog
		 */
		// $blog->setData([]);
		// $blog = $this->_blogInterfaceFactory->create();
		//  $blog->setTitle($params['titulo']);
		//  $blog->setContent($params['contenido']);
		//  $blog->setEmail($params['email']);
		//  $blog->setImage($params['img']);

		//  $blog->save();
		return $this->_pageFactory->create();

		/** 
		*	@var \Magento\Framework\Controller\Result\Json $result
		**/
		// $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
		// $result ->setData([			
		// 	'error' => 'false',
		// 	'blog_id' => $blog->getId(),

		// ]);

		// $result->setData($params); 


		return $result;
	}
}
