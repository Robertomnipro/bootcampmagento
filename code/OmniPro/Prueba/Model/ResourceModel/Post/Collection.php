<?php
namespace OmniPro\Prueba\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected $_idFieldName = 'id';
	protected $_eventPrefix = 'omnipro_post_collection';
	protected $_eventObject = 'post_collection';

    protected function _construct()
    {
        $this->_init('OmniPro\Prueba\Model\Post', 'OmniPro\Prueba\Model\ResourceModel\Post');
    }
}
