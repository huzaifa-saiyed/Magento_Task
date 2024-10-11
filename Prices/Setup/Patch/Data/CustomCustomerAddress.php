<?php
namespace Kitchen\Prices\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CustomCustomerAddress implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            'customers_types',
            [
                'type' => 'int',
                'label' => 'Customer Type',
                'input' => 'select',
                'required' => 0,
                'visible' => 1,
                'user_defined' => 0,
                'sort_order' => 10,
                'position' => 10,
                'system' => 0,
                'unique'  => 0,
                'is_visible_in_grid' => 1,
                'is_used_in_grid' => 1,
                'filterable' => 0,
                'searchable' => 0,
                'source' => \Kitchen\Prices\Model\Config\Source\CustomerType::class,
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'customers_types');
        $attribute->setData(
            'used_in_forms',[
                'adminhtml_customer', 
                'adminhtml_customer_address', 
                'customer_account_edit', 
                'customer_address_edit', 
                'customer_register_address', 
                'customer_account_create'
            ]
        );
        $attribute->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public static function getVersion()
    {
        return '1.0.0';
    }

    public static function getPatchName()
    {
        return 'AddCustomerAllowAttribute';
    }
}
