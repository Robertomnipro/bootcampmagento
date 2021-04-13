<?php

namespace OmniPro\Blog\Model\Blog;

use OmniPro\Blog\Model\ResourceModel\Blog\CollectionFactory;

class BlogDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $addFieldStrategies;
    protected $addFilterStrategies;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->collection = $collectionFactory->create();
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
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
