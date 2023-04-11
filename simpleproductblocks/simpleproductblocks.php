<?php
/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

if (!defined('_PERSONALIZATION_DIR_')) {
    define('_PERSONALIZATION_DIR_', dirname(__FILE__));
}

include_once(_PERSONALIZATION_DIR_ . '/classes/SimpleProducCategoryClass.php');


use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;



class SimpleProductBlocks extends Module implements WidgetInterface
{
    private $templateFile;

    public function __construct()
    {
        $this->name = 'simpleproductblocks';
        $this->author = 'Viktar Uladzimirau';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->ps_versions_compliancy = [
            'min' => '1.7.1.0',
            'max' => _PS_VERSION_,
        ];

        $this->bootstrap = true;
        parent::__construct();
        
        $this->displayName = $this->l('Simple Product Blocks');
        $this->description = $this->l('Pick a category and highlight its items, enhance customer experience with a lively homepage');
        $this->templateFile = 'module:simpleproductblocks/views/templates/hook/simpleproductblocks.tpl';
    }

    public function install()
    {
        $this->_clearCache('*');

        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_NBR_1', 10);
        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_CAT_1', (int) Context::getContext()->shop->getCategory());
        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_1', 0);

        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_NBR_2', 10);
        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_CAT_2', (int) Context::getContext()->shop->getCategory());
        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_2', 0);

        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_NBR_3', 10);
        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_CAT_3', (int) Context::getContext()->shop->getCategory());
        Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_3', 0);


        return parent::install()
            && $this->registerHook('displayHeader')
            && $this->registerHook('actionProductAdd')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('actionProductDelete')
            && $this->registerHook('displayHome')
            && $this->registerHook('displayOrderConfirmation2')
            && $this->registerHook('displayCrossSellingShoppingCart')
            && $this->registerHook('actionCategoryUpdate')
            && $this->registerHook('actionAdminGroupsControllerSaveAfter')
        ;
    }

    public function uninstall()
    {
        $this->_clearCache('*');

        return parent::uninstall();
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/style.css');
        $this->context->controller->addJS($this->_path . 'views/js/front.js');
        $this->context->controller->addJS($this->_path . 'views/js/plugins/slick.min.js');
    }


    public function hookActionProductAdd($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionProductUpdate($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionProductDelete($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionCategoryUpdate($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionAdminGroupsControllerSaveAfter($params)
    {
        $this->_clearCache('*');
    }

    public function _clearCache($template, $cache_id = null, $compile_id = null)
    {
        parent::_clearCache($this->templateFile);
    }

    public function getContent()
    {
        $output = '';
        $errors = [];
        
        if (Tools::isSubmit('submitFirstBlock')) {

            $nbr = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_NBR_1');
            if (!Validate::isInt($nbr) || $nbr <= 0) {
                $errors[] = $this->l('The number of products is invalid. Please enter a positive number.');
            }

            $cat = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_CAT_1');
            if (!Validate::isInt($cat) || $cat <= 0) {
                $errors[] = $this->l('The category ID is invalid. Please choose an existing category ID.');
            }

            $rand = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_1');
            if (!Validate::isInt($rand)) {
                $errors[] = $this->l('Invalid value for the "sort" flag.');
            }
            

            if (count($errors)) {
                $output = $this->displayError(implode('<br />', $errors));
            } else {
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_NBR_1', (int) $nbr);
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_CAT_1', (int) $cat);
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_1', (int) $rand);

                $this->_clearCache('*');
                
                $output = $this->displayConfirmation($this->l('The settings have been updated'));
            }
            
        }

        if (Tools::isSubmit('submitSecondBlock')) {

            $nbr = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_NBR_2');
            if (!Validate::isInt($nbr) || $nbr <= 0) {
                $errors[] = $this->l('The number of products is invalid. Please enter a positive number.');
            }

            $cat = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_CAT_2');
            if (!Validate::isInt($cat) || $cat <= 0) {
                $errors[] = $this->l('The category ID is invalid. Please choose an existing category ID.');
            }

            $rand = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_2');
            if (!Validate::isInt($rand)) {
                $errors[] = $this->l('Invalid value for the "sort" flag.');
            }
            if (count($errors)) {
                $output = $this->displayError(implode('<br />', $errors));
            } else {
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_NBR_2', (int) $nbr);
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_CAT_2', (int) $cat);
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_2', (bool) $rand);

                $this->_clearCache('*');

                $output = $this->displayConfirmation($this->l('The settings have been updated'));
            }
            
        }

        if (Tools::isSubmit('submitThirdBlock')) {

            $nbr = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_NBR_3');
            if (!Validate::isInt($nbr) || $nbr <= 0) {
                $errors[] = $this->l('The number of products is invalid. Please enter a positive number.');
            }

            $cat = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_CAT_3');
            if (!Validate::isInt($cat) || $cat <= 0) {
                $errors[] = $this->l('The category ID is invalid. Please choose an existing category ID.');
            }

            $rand = Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_3');
            if (!Validate::isInt($rand)) {
                $errors[] = $this->l('Invalid value for the "sort" flag.');
            }
            if (count($errors)) {
                $output = $this->displayError(implode('<br />', $errors));
            } else {
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_NBR_3', (int) $nbr);
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_CAT_3', (int) $cat);
                Configuration::updateValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_3', (bool) $rand);

                $this->_clearCache('*');

                $output = $this->displayConfirmation($this->l('The settings have been updated'));
            }
            
        }        

        return $output . $this->renderForm();
    }

    public function renderForm()
    {

        $fields_form_1 = [
            'form' => [
                'legend' => [
                    'title' => $this->trans('Settings', [], 'Admin.Global'),
                    'icon' => 'icon-cogs',
                ],
                'description' => $this->l('To add products to your homepage, simply add them to the corresponding product category (default: "Home").'),
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Number of products to be displayed'),
                        'name' => 'HOME_SIMPLEPTODUCTBLOCK_NBR_1',
                        'class' => 'fixed-width-xs',
                        'desc' => $this->l('Set the number of products that you would like to display on homepage (default: 10).'),
                    ],

                    [
                        'type' => 'select',
                        'options' => array(
                            'query' => SimpleProducCategoryClass::getCategoriesList(),
                            'id' => 'id_category',
                            'name' => 'category_name'
                        ),
                        'label' => $this->l('Product category'),
                        'name' => 'HOME_SIMPLEPTODUCTBLOCK_CAT_1',
                        'col' => 4,
                    ],

                    [
                        'type'      => 'radio',                              
                        'label'     => $this->l('Sort product'),     
                        'name'      => 'HOME_SIMPLEPTODUCTBLOCK_ORDER_1',                                                                                                                                                                                                                                                                                      
                        'values'    => [                              
                          [
                              
                            'value' => 0,    
                            'label' => $this->l('Random')                               
                          ],
                          [
                            'value' => 1,
                            'label' => $this->l('Product position asc')                   
                          ],
                          [
                            'value' => 2,
                            'label' => $this->l('Product name asc')                   
                          ],
                          [
                            'value' => 3,
                            'label' => $this->l('Product name desc')                   
                          ],
                          [
                            'value' => 4,
                            'label' => $this->l('Product price asc')                   
                          ],
                          [
                            'value' => 5,
                            'label' => $this->l('Product price desc')                   
                          ],
                        ],
                    ],

                ],
                'submit' => [
                    'title' =>  $this->l('Save'),
                    'name' => 'submitFirstBlock',
                ],
            ],

        ];

        $fields_form_2 = [
            'form' => [
                'legend' => [
                    'title' =>  $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],

                'description' =>  $this->l('To add products to your homepage, simply add them to the corresponding product category (default: "Home").'),
                'input' => [
                    [
                        'type' => 'text',
                        'label' =>  $this->l('Number of products to be displayed'),
                        'name' => 'HOME_SIMPLEPTODUCTBLOCK_NBR_2',
                        'class' => 'fixed-width-xs',
                        'desc' =>  $this->l('Set the number of products that you would like to display on homepage (default: 10).'),
                    ],

                    [
                        'type' => 'select',
                        'options' => array(
                            'query' => SimpleProducCategoryClass::getCategoriesList(),
                            'id' => 'id_category',
                            'name' => 'category_name'
                        ),
                        'label' => $this->l('Product category'),
                        'name' => 'HOME_SIMPLEPTODUCTBLOCK_CAT_2',
                        'col' => 4,
                    ],

                    [
                        'type'      => 'radio',                              
                        'label'     => $this->l('Sort product'),     
                        'name'      => 'HOME_SIMPLEPTODUCTBLOCK_ORDER_2',                                                                                                                                                                                                                                                                                      
                        'values'    => [                              
                          [
                              
                            'value' => 0,    
                            'label' => $this->l('Random')                               
                          ],
                          [
                            'value' => 1,
                            'label' => $this->l('Product position asc')                   
                          ],
                          [
                            'value' => 2,
                            'label' => $this->l('Product name asc')                   
                          ],
                          [
                            'value' => 3,
                            'label' => $this->l('Product name desc')                   
                          ],
                          [
                            'value' => 4,
                            'label' => $this->l('Product price asc')                   
                          ],
                          [
                            'value' => 5,
                            'label' => $this->l('Product price desc')                   
                          ],
                        ],
                    ],
                ],
                'submit' => [
                    'title' =>  $this->l('Save'),
                    'name' => 'submitSecondBlock',
                ],
            ],
        ];

        $fields_form_3 = [
            'form' => [
                'legend' => [
                    'title' =>  $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],

                'description' =>  $this->l('To add products to your homepage, simply add them to the corresponding product category (default: "Home").'),
                'input' => [
                    [
                        'type' => 'text',
                        'label' =>  $this->l('Number of products to be displayed'),
                        'name' => 'HOME_SIMPLEPTODUCTBLOCK_NBR_3',
                        'class' => 'fixed-width-xs',
                        'desc' =>  $this->l('Set the number of products that you would like to display on homepage (default: 10).'),
                    ],

                    [
                        'type' => 'select',
                        'options' => array(
                            'query' => SimpleProducCategoryClass::getCategoriesList(),
                            'id' => 'id_category',
                            'name' => 'category_name'
                        ),
                        'label' => $this->l('Product category'),
                        'name' => 'HOME_SIMPLEPTODUCTBLOCK_CAT_3',
                        'col' => 4,
                    ],

                    [
                        'type'      => 'radio',                              
                        'label'     => $this->l('Sort product'),     
                        'name'      => 'HOME_SIMPLEPTODUCTBLOCK_ORDER_3',                                                                                                                                                                                                                                                                                      
                        'values'    => [                              
                          [
                              
                            'value' => 0,    
                            'label' => $this->l('Random')                               
                          ],
                          [
                            'value' => 1,
                            'label' => $this->l('Product position asc')                   
                          ],
                          [
                            'value' => 2,
                            'label' => $this->l('Product name asc')                   
                          ],
                          [
                            'value' => 3,
                            'label' => $this->l('Product name desc')                   
                          ],
                          [
                            'value' => 4,
                            'label' => $this->l('Product price asc')                   
                          ],
                          [
                            'value' => 5,
                            'label' => $this->l('Product price desc')                   
                          ],
                        ],
                    ],
                ],
                'submit' => [
                    'title' =>  $this->l('Save'),
                    'name' => 'submitThirdBlock',
                ],
            ],
        ];        

        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$fields_form_1, $fields_form_2, $fields_form_3]);
    }

    public function getConfigFieldsValues()
    {
        return [
            'HOME_SIMPLEPTODUCTBLOCK_NBR_1' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_NBR_1', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_NBR_1')),
            'HOME_SIMPLEPTODUCTBLOCK_CAT_1' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_CAT_1', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_1')),
            'HOME_SIMPLEPTODUCTBLOCK_ORDER_1' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_1', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_ORDER_1')),

            'HOME_SIMPLEPTODUCTBLOCK_NBR_2' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_NBR_2', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_NBR_2')),
            'HOME_SIMPLEPTODUCTBLOCK_CAT_2' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_CAT_2', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_2')),
            'HOME_SIMPLEPTODUCTBLOCK_ORDER_2' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_2', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_ORDER_2')),

            'HOME_SIMPLEPTODUCTBLOCK_NBR_3' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_NBR_3', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_NBR_3')),
            'HOME_SIMPLEPTODUCTBLOCK_CAT_3' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_CAT_3', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_3')),
            'HOME_SIMPLEPTODUCTBLOCK_ORDER_3' => Tools::getValue('HOME_SIMPLEPTODUCTBLOCK_ORDER_3', (int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_ORDER_3')),
        ];
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('simpleproductblocks'))) {
            $variables = $this->getWidgetVariables($hookName, $configuration);

            if (empty($variables)) {
                return false;
            }

            $this->smarty->assign($variables);
        }

        return $this->fetch($this->templateFile, $this->getCacheId('simpleproductblocks'));
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $products_1 = $this->getProducts(
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_1'),
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_NBR_1'),
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_ORDER_1')
        );
        $category_1 = new Category((int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_1'), (int)$context->language->id);
        $category_name_1 = $category_1->name;
        $category_link_1 = Context::getContext()->link->getCategoryLink($this->getConfigFieldsValues()['HOME_SIMPLEPTODUCTBLOCK_CAT_1']);

        $products_2 = $this->getProducts(
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_2'),
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_NBR_2'),
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_ORDER_2')
        );
        $category_2 = new Category((int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_2'), (int)$context->language->id);
        $category_name_2 = $category_2->name;
        $category_link_2 = Context::getContext()->link->getCategoryLink($this->getConfigFieldsValues()['HOME_SIMPLEPTODUCTBLOCK_CAT_2']);


        $products_3 = $this->getProducts(
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_3'),
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_NBR_3'),
            Configuration::get('HOME_SIMPLEPTODUCTBLOCK_ORDER_3')
        );
        $category_3 = new Category((int) Configuration::get('HOME_SIMPLEPTODUCTBLOCK_CAT_3'), (int)$context->language->id);
        $category_name_3 = $category_3->name;
        $category_link_3 = Context::getContext()->link->getCategoryLink($this->getConfigFieldsValues()['HOME_SIMPLEPTODUCTBLOCK_CAT_3']);


            return [

                'products_1' => $products_1,
                'category_name_1'=> $category_name_1,
                'category_link_1' => $category_link_1,

                'products_2' => $products_2,
                'category_name_2'=> $category_name_2,
                'category_link_2' => $category_link_2,


                'products_3' => $products_3,
                'category_name_3'=> $category_name_3,
                'category_link_3' => $category_link_3,

            ];


        return false;
    }

    protected function getProducts($cat = null, $nbr_products = null, $order_products = null )
    {

        $category = new Category((int) $cat);

        $searchProvider = new CategoryProductSearchProvider(
            $this->context->getTranslator(),
            $category
        );

        $context = new ProductSearchContext($this->context);


        $query = new ProductSearchQuery();

        $nProducts = $nbr_products;

        if ($nProducts < 0) {
            $nProducts = 12;
        }

        $query
            ->setResultsPerPage($nProducts)
            ->setPage(1)
        ;

        if ((int)$order_products === 0) {
            $query->setSortOrder(SortOrder::random());
        } elseif ((int)$order_products === 1) {
            $query->setSortOrder(new SortOrder('product', 'position', 'asc'));
        } elseif ((int)$order_products === 2) {
            $query->setSortOrder(new SortOrder('product', 'name', 'asc'));
        } elseif ((int)$order_products === 3) {
            $query->setSortOrder(new SortOrder('product', 'name', 'desc'));
        } elseif ((int)$order_products === 4) {
            $query->setSortOrder(new SortOrder('product', 'price', 'asc'));
        } elseif ((int)$order_products === 5) {
            $query->setSortOrder(new SortOrder('product', 'price', 'desc'));
        }

        $result = $searchProvider->runQuery(
            $context,
            $query
        );


        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = $presenterFactory->getPresenter();

        $products_for_template = [];

        foreach ($result->getProducts() as $rawProduct) {

            if($rawProduct['quantity'] > 0){
                $products_for_template[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($rawProduct),
                    $this->context->language
                );
            }
        }


        return $products_for_template;
    }

    protected function getCacheId($name = null)
    {
        $cacheId = parent::getCacheId($name);
        if (!empty($this->context->customer->id)) {
            $cacheId .= '|' . $this->context->customer->id;
        }

        return $cacheId;
    }

}
