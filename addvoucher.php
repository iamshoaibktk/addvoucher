<?php
/**
* 2007-2024 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2024 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Addvoucher extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'addvoucher';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'iamshoaibktk@gmail.com';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('show voucher under price ');
        $this->description = $this->l('show voucher under price ');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('ADDVOUCHER_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayProductPriceBlock');
    }

    public function uninstall()
    {
        Configuration::deleteByName('ADDVOUCHER_LIVE_MODE');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output;
    }

    public function hookDisplayProductPriceBlock($params)
    {
        if($params['type'] == 'custom_price'){


            $product = new Product($params['product']['id_product']);
            // Example: Assuming you want to get the vouchers for this product
            $discounts = CartRule::getCustomerCartRules(
                $this->context->language->id,
                $this->context->customer->id,
                true,
                true
            );

                      // Render your discount voucher template
                      $this->context->smarty->assign([
                        'discounts' => $discounts,
                    ]);
        
                    // return $this->display(__FILE__, 'views/templates/hook/product_discount.tpl');

            // dump($discounts);

            return $this->display(__FILE__, 'views/templates/hook/addvoucher.tpl');
        }
    }
}
