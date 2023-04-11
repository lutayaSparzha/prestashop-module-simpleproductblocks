{**
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
 *}

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <section class="list-section">
        <div class='products-header'>
          <div>
            <h2>{$category_name_1|truncate:20:'...'}</h2>
            <hr>
          </div>
          <div class="arrows-container_1"></div>
        </div>
        <div class="products_1" data-item="products_container"
          style="position: relative;overflow: hidden; max-height:305px;">
          {foreach from=$products_1 item="product"}
            {include file='module:simpleproductblocks/views/templates/hook/product.tpl' product=$product}
          {/foreach}
        </div>
        <div class="products-footer">
          <a href="{$category_link_1}">{l s='More from this category' mod='simpleproductblocks'}</a>
        </div>
      </section>
    </div>
    <div class="col-md-4">
      <section class="list-section">
        <div class='products-header'>
          <div>
            <h2>{$category_name_2|truncate:20:'...'}</h2>
            <hr>
          </div>
          <div class="arrows-container_2"></div>
        </div>
        <div class="products_2" data-item="products_container"
          style="position: relative;overflow: hidden; max-height:305px;">
          {foreach from=$products_2 item="product"}
            {include file='module:simpleproductblocks/views/templates/hook/product.tpl' product=$product}
          {/foreach}
        </div>
        <div class="products-footer">
          <a href="{$category_link_2}">{l s='More from this category' mod='simpleproductblocks'}</a>
        </div>
      </section>
    </div>
    <div class="col-md-4">
      <section class="list-section">
        <div class='products-header'>
          <div>
            <h2>{$category_name_3|truncate:20:'...'}</h2>
            <hr>
          </div>
          <div class="arrows-container_3"></div>
        </div>
        <div class="products_3" data-item="products_container"
          style="position: relative;overflow: hidden; max-height:305px;">
          {foreach from=$products_3 item="product"}
            {include file='module:simpleproductblocks/views/templates/hook/product.tpl' product=$product}
          {/foreach}
        </div>
        <div class="products-footer">
          <a href="{$category_link_3}">{l s='More from this category' mod='simpleproductblocks'}</a>
        </div>
      </section>
    </div>
  </div>
</div>