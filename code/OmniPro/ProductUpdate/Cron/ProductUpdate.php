<?php
namespace OmniPro\ProductUpdate\Cron;

use OmniPro\ProductUpdate\Logger\Logger;
use \OmniPro\ProductUpdate\Model\UpdateProduct;


class ProductUpdate
{
    private $_logger;
    private $_productUpdate;
    
    public function __construct(Logger $logger, UpdateProduct $productUpdate )
    {
        $this->_logger = $logger;
        $this->_productUpdate = $productUpdate;
    }
    public function execute()
	{
        $this->_logger->info("Cron omnin product update working");
        try {
            $this->_productUpdate->updateProductCsv();
        } catch (\Throwable $e) {
            $this->_logger->error("Cron say: ".$e);
        }

		return $this;

	}
}
