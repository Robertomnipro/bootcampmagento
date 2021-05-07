<?php
namespace OmniPro\ProductUpdate\Model;

use GuzzleHttp\Promise\Is;
use OmniPro\ProductUpdate\Helper\Email;
use OmniPro\ProductUpdate\Helper\ReaderCSV;
use OmniPro\ProductUpdate\Logger\Logger;

use function PHPUnit\Framework\isNull;

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
     * @var \Magento\Framework\App\State
     */
    private $_state;

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
        \Magento\Framework\App\State $state,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
        \Magento\Catalog\Api\Data\ProductInterfaceFactory $productInterface,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_email= $email;
        $this->_readerCSV = $readerCSV;
        $this->logger = $logger;
        $this->_state = $state;
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
       
        $this->_email->sendEmail();
        $this->_state->emulateAreaCode(
            'frontend', 
            function () { 
                $data = $this->_readerCSV->readCsv();
                foreach (array_slice($data,1) as $key => $value) {  
                    $this->logger->debug('DATA Model: ' . implode('|',$value));   
                }
                $this->createProducts($data);
            }
        );
    }

    public function createProducts($dataCsv)
    {   
        $errorProduct = 0;
        foreach (array_slice($dataCsv,1) as $key => $value) {  
            // $this->logger->debug('DATA create product: ' . implode('|',$value));     
            /**
             * @var    \Magento\Catalog\Api\Data\ProductInterface $product
             */ 
            if(isset($value[0])&&isset($value[1])&&isset($value[2])&&isset($value[3])&&isset($value[4])&&isset($value[5])&&isset($value[6])&&isNull($value[7])){
                $product = $this->_productInterface->create();
                $product->setSku($value[0]);
                $product->setName($value[1]);
                $product->setTypeId(\Magento\Catalog\Model\Product\type::TYPE_SIMPLE);
                $product->setVisibility(4);
                $product->setPrice($value[2]);
                $product->setAttributeSetId(4);
                $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
                $this->_productRepositoryInterface->save($product);  
                
                
            }else{
                $errorProduct ++;
            }
        }
        $productValid= count( $dataCsv) - $errorProduct - 1;
        $this->logger->debug('Product created/updated: ' . $productValid); 
        $this->logger->debug('Product error: ' . $errorProduct); 

    }
}
