<?php
namespace OmniPro\DataPathTest\Helper;

use Magento\Framework\App\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{   
    const CONFIG_PATH = 'omniprosection/omniprogroup';

    public function __construct($context)
    {
        parent::__construct($context);
    }

    public function getConfig(\Magento\Framework\App\Helper\Context $config, $storeId = null) 
    {
        // return $this->scopeConfig->getValue(
        //     self::CONFIG_PATH.$config,
        //     ScopeInterface::,
        //     $storeId
        // );
    }
}
