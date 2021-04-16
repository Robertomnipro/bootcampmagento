<?php

namespace OmniPro\Blog\Ui\DataProvider\Blog;

use OmniPro\Blog\Model\ResourceModel\Blog\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,  
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName,  $requestFieldName, $meta, $data);
    }
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();
        /** @var Customer $customer */
        foreach ($items as $posts) {
            // notre fieldset s'apelle "contact" d'ou ce tableau pour que magento puisse retrouver ses datas :
            $this->loadedData[$posts->getId()]['post'] = $posts->getData();
        }


        return $this->loadedData;

    }
}
