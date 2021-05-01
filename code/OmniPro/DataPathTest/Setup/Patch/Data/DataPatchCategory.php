<?php

namespace OmniPro\DataPathTest\Setup\Patch\Data;

use \Magento\Catalog\Setup\CategorySetupFactory;
use \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

use \Magento\Eav\Setup\EavSetup;
use \Magento\Eav\Setup\EavSetupFactory;
use \Magento\Framework\Setup\ModuleDataSetupInterface;
use \Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Catalog\Model\Product;


class DataPatchCategory  implements
    DataPatchInterface,
    PatchRevertableInterface
{

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $_moduleDataSetup;

    /** @var \Magento\Eav\Setup\EavSetupFactory */
    private $_eavSetupFactory;

    /** 
     * @var \Magento\Catalog\Setup\CategorySetupFactory
    */

    private $_categorySetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        CategorySetupFactory $categorySetupFactory

    ) {
        $this->_moduleDataSetup = $moduleDataSetup;
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->_categorySetupFactory = $categorySetupFactory;
    }

    public function apply()
    {
        $this->_moduleDataSetup->getConnection()->startSetup();
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $this->_moduleDataSetup]);
        $eavSetup->addAttribute('catalog_product', 'my_custom_logo', [
            'type' => 'varchar',
            'label' => 'My Custom Logo',
            'input' => 'image',
            'source' => '',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
            'visible' => true,
            'user_defined' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => false,
            'group' => 'General Information',
        ]);
         $this->_moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        /**
         * This is dependency to another patch. Dependency should be applied first
         * One patch can have few dependencies
         * Patches do not have versions, so if in old approach with Install/Ugrade data scripts you used
         * versions, right now you need to point from patch with higher version to patch with lower version
         * But please, note, that some of your patches can be independent and can be installed in any sequence
         * So use dependencies only if this important for you
         */
        return [];
    }
    public function getAliases()
    {
        /**
         * This internal Magento method, that means that some patches with time can change their names,
         * but changing name should not affect installation process, that's why if we will change name of the patch
         * we will add alias here
         */
        return [];
    }
      /**
   * {@inheritdoc}
   */
   public static function getVersion()
   {
      return '1.0.0';
   }
   public function revert()
   {
    $this->_moduleDataSetup->getConnection()->startSetup();

    $eavSetup = $this->_eavSetupFactory->create(['setup' => $this->_moduleDataSetup]);
    $eavSetup->removeAttribute(Product::ENTITY, 'my_custom_logo');

    $this->_moduleDataSetup->getConnection()->endSetup();
   }
}