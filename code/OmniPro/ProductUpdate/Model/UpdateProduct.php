<?php
namespace OmniPro\ProductUpdate\Model;

use OmniPro\ProductUpdate\Helper\Email;
use OmniPro\ProductUpdate\Helper\ReaderCSV;

class UpdateProduct extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'omnipro_productupdate_update_product';


     /**
     *
     * @var  OmniPro\ProductUpdate\Helper\Email;
     */
    private $_email;

      /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var  OmniPro\ProductUpdate\Helper\ReaderCSV;
     */
    private $_readerCSV;

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'update_product';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \OmniPro\ProductUpdate\Helper\Email $email,
        \OmniPro\ProductUpdate\Helper\ReaderCSV $readerCSV,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_email= $email;
        $this->_readerCSV = $readerCSV;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    // /**
    //  * Initialize resource model
    //  *
    //  * @return void
    //  */
    // protected function _construct()
    // {
    //     $this->_init('OmniPro\ProductUpdate\Model\ResourceModel\UpdateProduct');
    // }

    /**
     * Return a unique id for the model.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function updateProductCsv()
    {
        $data = $this->_readerCSV->readCsv();
        return $data;
    }
}
