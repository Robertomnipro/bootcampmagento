<?php
namespace OmniPro\Blog\Plugin;

class BlogRepositoryPlugin
{
    /**
     * @param \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Magento\Framework\Api\ImageProcessorInterface
     */
    private $imageProcessor;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Api\ImageProcessorInterface $imageProcessor
    )
    {
        $this->logger = $logger;
        $this->imageProcessor = $imageProcessor;

    }

    public function beforeSave(
        \OmniPro\Blog\Api\BlogRepositoryInterface $blogRepository,
        \OmniPro\Blog\Api\Data\BlogInterface $blog
        ) {
            $extensionAttributes = $blog->getExtensionAttributes();
            if($extensionAttributes) {
                $image = $extensionAttributes->getImage();
                if($image) {
                    $imagePath = $this->imageProcessor->processImageContent('blog/post', $image);
                    $blog->setImg($imagePath);
                }
            }
            return [$blog];
    }
}
