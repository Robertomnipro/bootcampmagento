<?php
namespace OmniPro\Blog\Block;

class Insert extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        array $data = []
    ) {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context, $data);
    }

    public function execute()
    {
         return $this->_pageFactory->create();
    }   
}
