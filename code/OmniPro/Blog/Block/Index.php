<?php
namespace OmniPro\Blog\Block;

// use OmniPro\Prueba\Model\PostFactory;
use Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

class Index extends Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */

    protected $_postFactory;

    public function __construct(
        Context $context,
        // PostFactory $postFactory,
        array $data = []
    ) {
        // $this->_postFactory = $postFactory;
        parent::__construct($context, $data);
    }

    public function sayHello()
	{
		return __('Hello World');
	}

    public function getPostCollection()
    {
		$post = $this->_postFactory->create();
		return $post->getCollection();
	}

    public function setTitle($title)
    {
        $this->setData('title',$title);
    }


}
