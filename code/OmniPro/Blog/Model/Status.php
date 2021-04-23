<?php
namespace OmniPro\Blog\Model;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    public function toOptionArray()
    {
        return [
            [
                self::STATUS_ENABLED => __('Enabled'),
                self::STATUS_DISABLED => __('Disabled'),
            ],
        ];
    }

    public static function getOptionArray()
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled'),
        ];
    }
}
