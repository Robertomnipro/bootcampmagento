<?php
namespace OmniPro\Blog\Api;

use \OmniPro\Blog\Api\Data\BlogInterface;
use \OmniPro\Blog\Api\Data\BlogSearchResultInterface;

interface BlogRepositoryInterface
{
    /**
     * @param int $id
     * @return \OmniPro\Blog\Api\Data\BlogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);
 
    /**
     * @param \OmniPro\Blog\Api\Data\BlogInterface $blog
     * @return \OmniPro\Blog\Api\Data\BlogInterface
     */
    public function save(BlogInterface $blog);
 
    /**
     * @param \OmniPro\Blog\Api\Data\BlogInterface $blog
     * @return void
     */
    public function delete(BlogInterface $blog);
 
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \OmniPro\Blog\Api\Data\BlogSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
