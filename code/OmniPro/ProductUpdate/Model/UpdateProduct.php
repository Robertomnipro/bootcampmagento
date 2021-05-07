<?php
namespace OmniPro\ProductUpdate\Model;

use OmniPro\ProductUpdate\Helper\Email;
use OmniPro\ProductUpdate\Helper\ReaderCSV;
use OmniPro\ProductUpdate\Logger\Logger;

class UpdateProduct extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'omnipro_productupdate_update_product';

    /**
     * @var  \Magento\Catalog\Api\ProductRepositoryInterface
     */
   
    private $_productRepositoryInterface;

     /**
     *
     * @var  \Magento\Catalog\Api\Data\ProductInterfaceFactory;
     */
    private $_productInterface;
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
        Email $email,
        ReaderCSV $readerCSV,
        Logger $logger,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
        \Magento\Catalog\Api\Data\ProductInterfaceFactory $productInterface,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_email= $email;
        $this->_readerCSV = $readerCSV;
        $this->logger = $logger;
        $this->_productInterface = $productInterface;
        $this->_productRepositoryInterface= $productRepositoryInterface;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

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
        foreach (array_slice($data,1) as $key => $value) {  
            $this->logger->debug('DATA' . implode('|',$value));   
        }
        $this->_email->sendEmail();
        $this->createProducts($data);
    }

    public function createProducts($dataCsv)
    {
        foreach (array_slice($dataCsv,1) as $key => $value) {  
            /**
             * @var    \Magento\Catalog\Api\Data\ProductInterface $product
             */ 
            $product = $this->_productInterface->create();
            $product->setSku($value[0]);
            $product->setName($value[1]);
            $product->setTypeId(\Magento\Catalog\Model\Product\type::TYPE_SIMPLE);
            $product->setVisibility(4);
            $product->setPrice($value[2]);
            $product->setAttributeSetId(4);
            $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
            $this->_productRepositoryInterface->save($product);     


        }
    }
}
