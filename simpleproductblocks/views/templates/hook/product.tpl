{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
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
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}


 <div class="product-block col-md-12">

    <div class="product-img-section">
      {block name='product_thumbnail'}
        {if $product.cover}
          <a href="{$product.url}">
            <img class="simple-product-thumbnail" src="{$product.cover.bySize.home_default.url}"
              alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
              loading="lazy" data-full-size-image-url="{$product.cover.large.url}"
              width="{$product.cover.bySize.home_default.width}" height="{$product.cover.bySize.home_default.height}" />
          </a>
        {else}
          <a href="{$product.url}">
            <img class="simple-product-thumbnail" src="{$urls.no_picture_image.bySize.home_default.url}" loading="lazy"
              width="{$urls.no_picture_image.bySize.home_default.width}"
              height="{$urls.no_picture_image.bySize.home_default.height}" />
          </a>
        {/if}
      {/block}
    </div>

    <div class="product-description-section">
          {block name='product_name'}
            {if $page.page_name == 'index'}
              <h3 class="simple-product-title"><a href="{$product.url}"
                  content="{$product.url}">{$product.name|truncate:25:'...'}</a></h3>
            {else}
              <h2 class="simple-product-title"><a href="{$product.url}"
                  content="{$product.url}">{$product.name|truncate:25:'...'}</a></h2>
            {/if}
          {/block}

          {block name='product_description_short'}
            <div class="simple-product-description-short">{$product.description_short|strip_tags:'UTF-8'|truncate:60:'...'}</div>
          {/block}
    </div>

    <div class="product-buttons-section">

        {block name='product_price_and_shipping'}
          {if $product.show_price}
            <div class="simple-block-product-price-and-shipping">
              {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}

                <span class="regular-price" aria-label="{l s='Regular price' mod='simpleproductblocks'}">{$product.regular_price}</span>
                {if $product.discount_type === 'percentage'}
                  <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                {elseif $product.discount_type === 'amount'}
                  <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                {/if}
              {/if}

              {hook h='displayProductPriceBlock' product=$product type="before_price"}

              <span class="price" aria-label="{l s='Price' mod='simpleproductblocks'}">
                {capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
                {if '' !== $smarty.capture.custom_price}
                  {$smarty.capture.custom_price nofilter}
                {else}
                  {$product.price}
                {/if}
              </span>

              {hook h='displayProductPriceBlock' product=$product type='unit_price'}

              {hook h='displayProductPriceBlock' product=$product type='weight'}
            </div>
          {/if}
        {/block}    


      
      <div class="product-actions js-product-actions">
            {block name='product_buy'}
              <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                <input type="hidden" name="token" value="{$static_token}">
                <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
                <input type="hidden" name="id_customization" value="{$product.id_customization}" id="product_customization_id" class="js-product-customization-id">



                  <div class="product-add-to-cart js-product-add-to-cart">
                    {if !$configuration.is_catalog}
                      {* <span class="simple-block-control-label">{l s='Quantity' mod='simpleproductblocks'}</span> *}
              
                      {block name='product_quantity'}
                        <div class="product-quantity clearfix">
                          <div class="qty">
                            <input
                              type="number"
                              name="qty"
                              id="simple_block_input_quantity_wanted"
                              inputmode="numeric"
                              pattern="[0-9]*"
                              {if $product.quantity_wanted}
                                value="{$product.quantity_wanted}"
                                min="{$product.minimal_quantity}"
                              {else}
                                value="1"
                                min="1"
                              {/if}
                              class="input-group"
                              aria-label="{l s='Quantity' mod='simpleproductblocks'}"
                            >
                          </div>

                          <div class="add">
                            <button
                              class="add-to-cart simple-block-button"
                              data-button-action="add-to-cart"
                              type="submit"
                              {if !$product.add_to_cart_url}
                                disabled
                              {/if}
                            >
                              <i class="material-icons shopping-cart">&#xE547;</i>

                            </button>
                          </div>
                
                        </div>
                      {/block}
                  
                    {/if}
                  </div>

                {* Input to refresh product HTML removed, block kept for compatibility with themes *}
                {block name='product_refresh'}{/block}
              </form>
            {/block}
      </div>
      
    </div>

 </div>

