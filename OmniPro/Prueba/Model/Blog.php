<?php
namespace OmniPro\Prueba\Model;

class Blog extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface, \OmniPro\Prueba\Api\Data\BlogInterface
{
    const CACHE_TAG = 'omnipro_prueba_blog';

    const TITLE = 'title';
    const CONTENT = 'content';
    const IMAGE = 'image';
    const EMAIL = 'email';

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
    protected $_eventPrefix = 'blog';

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
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\OmniPro\Prueba\Model\ResourceModel\Blog::class);
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

    /**
     * return title
     *
     * @return void
     */    
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

     /**
     * set title blog.
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->setData(self::TITLE,$title);
    }

    /**
     * return content blog
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * set content blog
     * @param string $content
     * @return void
     */
    public function setContent($content)
    {     
        $this->setData(self::CONTENT,$content);
    }

     /**
     * return image blog
     *
     * @return string
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * set image blog
     * @param string $image
     * @return void
     */
    public function setImage($image)
    {
        $this->setData(self::IMAGE,$image);   
    }

      /**
     * return email blog owner
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);               
        
    }

    /**
     * set email blog owner
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->setData(self::EMAIL,$email);   
    }






}
