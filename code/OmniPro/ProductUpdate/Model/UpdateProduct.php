<?php
namespace OmniPro\ProductUpdate\Model;

use OmniPro\ProductUpdate\Helper\Email;
use OmniPro\ProductUpdate\Helper\ReaderCSV;
use OmniPro\ProductUpdate\Logger\Logger;
use Magento\Catalog\Api\SpecialPriceInterface;
use Magento\Catalog\Api\Data\SpecialPriceInterfaceFactory;

use function PHPUnit\Framework\isNull;

class UpdateProduct extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'omnipro_productupdate_update_product';

     /**
     * @var SpecialPriceInterface
     */
    private $_specialPrice;
 
    /**
     * @var SpecialPriceInterfaceFactory
     */
    private $_specialPriceFactory;
 

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
     * @var Magento\CatalogInventory\Api\StockRegistryInterface
     */
    private $_stockRegistry;
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
        SpecialPriceInterface $specialPrice,
        SpecialPriceInterfaceFactory $specialPriceFactory,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistryInterface,
        \Magento\Framework\App\State $state,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
        \Magento\Catalog\Api\Data\ProductInterfaceFactory $productInterface,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_stockRegistry= $stockRegistryInterface;
        $this->_email= $email;
        $this->_readerCSV = $readerCSV;
        $this->logger = $logger;
        $this->_state = $state;
        $this->_productInterface = $productInterface;
        $this->_productRepositoryInterface= $productRepositoryInterface;
        $this->_specialPrice = $specialPrice;
        $this->_specialPriceFactory = $specialPriceFactory;
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
        // try {
            foreach (array_slice($dataCsv,1) as $key => $value) {  
                $this->logger->debug('lenght data: ' . count($value)); 
                /**
                 * @var    \Magento\Catalog\Api\Data\ProductInterface $product
                 */ 
                if(is_string($value[0])&&is_string($value[1])&&is_string($value[2])&&is_string($value[3])&&is_string($value[4])&&is_string($value[5])&&is_string($value[6])&&is_string($value[7])){
                    $product = $this->_productInterface->create();
                    $product->setSku($value[0]);
                    $product->setName($value[1]);
                    $product->setTypeId(\Magento\Catalog\Model\Product\type::TYPE_SIMPLE);
                    $product->setVisibility(4);
                    $product->setPrice($value[2]);
                    $product->setAttributeSetId(4);
                    $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
                    $this->_productRepositoryInterface->save($product);  
                    
                    $stockItem = $this->_stockRegistry->getStockItemBySku($product->getSku());
                    $stockItem->setIsInStock(1);
                    $stockItem->setQty($value[6]);              
                    $this->_stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);

                    // $priceFrom = $value[4]; // future date to current date
                    // $priceTo =  $value[5]; // future date to price from

                    $updateDatetime = new \DateTime();


                    // $priceFrom = $updateDatetime->modify($priceFrom)->format('Y-m-d H:i:s');
                    // $priceTo = $updateDatetime->modify($priceTo)->format('Y-m-d H:i:s');

                    $prices[] = $this->_specialPriceFactory->create() 
                        ->setSku($product->getSku())
                        ->setStoreId(0)
                        ->setPrice($value[3])
                        ->setPriceFrom($updateDatetime->modify($value[4])->format('Y-m-d H:i:s'))
                        ->setPriceTo($updateDatetime->modify($value[5])->format('Y-m-d H:i:s'));
        
                        $product = $this->_specialPrice->update($prices);
         


                    //  echo $priceFrom.$priceTo;

                    
                }else{
                    $errorProduct ++;
                }
            }
        // } catch (\Throwable $th) {
        //     $errorProduct ++;

        //     //throw $th;
        // }    
        
        $productValid= count( $dataCsv) - $errorProduct - 1;
        $this->logger->debug('Product created/updated: ' . $productValid); 
        $this->logger->debug('Product error: ' . $errorProduct); 

    }
}
