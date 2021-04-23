<?php

namespace OmniPro\DataPathTest\Setup\Patch\Data;

use \Magento\Eav\Setup\EavSetup;
use \Magento\Eav\Setup\EavSetupFactory;
use \Magento\Framework\Setup\ModuleDataSetupInterface;
use \Magento\Framework\Setup\Patch\DataPatchInterface;

class DatapatchTest  implements
    DataPatchInterface
{

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $_moduleDataSetup;

    /** @var \Magento\Eav\Setup\EavSetupFactory */
    private $_eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory

    ) {
        $this->_moduleDataSetup = $moduleDataSetup;
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $this->_moduleDataSetup->getConnection()->startSetup();
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $this->_moduleDataSetup]);
        $eavSetup->addAttribute('catalog_product', 'my_custom_attribute', [
            'type' => 'text',
            'backend' => '',
            'frontend' => '',
            'label' => 'My custom attribute',
            'input' => 'text',
            'class' => '',
            'source' => '',
            'visible' => true,
            'required' => true,
            'user_defined' => false,
            'default' => '',
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'used_in_product_listing' => true,
            'unique' => false,
            'apply_to' => '',
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
      return '2.0.0';
   }
}

