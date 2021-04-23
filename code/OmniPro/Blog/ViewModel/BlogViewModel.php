<?php
namespace OmniPro\Blog\ViewModel;

class BlogViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
   /**
     * @param \OmniPro\Blog\Api\BlogRepositoryInterface
     */
    private $blogRepository;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        \OmniPro\Blog\Api\BlogRepositoryInterface $blogRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->blogRepository = $blogRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        
    }

    public function getPosts() {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $posts = $this->blogRepository->getList($searchCriteria)->getItems();
        return $posts;
    }

    public function getText() {
        return 'Hola View Model';
    }
}
