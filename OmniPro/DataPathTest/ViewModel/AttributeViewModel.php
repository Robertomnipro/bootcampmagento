<?php
namespace OmniPro\DataPathTest\ViewModel;



class AttributeViewModel
{

    private $_scopeConfig;

private $_storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->_storeManager=$storeManager;
        $this->_scopeConfig= $scopeConfig;
    }

    public function getConfig()
    {
        $id = $this->_storeManager->getStore()->getId();
        $config = $this->_scopeConfig->getValue("omniprosection/omniprogroup/omniprofield",
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        $id   
        );
        return $config;
    }
}
