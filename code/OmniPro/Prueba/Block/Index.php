<?php
namespace OmniPro\Prueba\Block;
class Index extends \Magento\Framework\View\Element\Template
{
    protected $_postFactory;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\OmniPro\Prueba\Model\PostFactory $postFactory
	)
	{
		$this->_postFactory = $postFactory;
		parent::__construct($context);
	}

    public function getPostCollection()
    {
        $post = $this->_postFactory->create();
		return $post->getCollection();
    }

}