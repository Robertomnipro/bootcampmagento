<?php
namespace OmniPro\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface BlogSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \OmniPro\Blog\Api\Data\BlogInterface[]
     */
    public function getItems();
 
    /**
     * @param \OmniPro\Blog\Api\Data\BlogInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
