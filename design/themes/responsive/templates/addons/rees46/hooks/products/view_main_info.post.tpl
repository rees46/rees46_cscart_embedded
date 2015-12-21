{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
	{if ($runtime.controller == 'products' && $runtime.mode == 'quick_view')}
		{if $product}
		        REES46.addReadyListener(function() {
				param = {
					{$features=$product.header_features}
					{if $features}
					{foreach from=$features name=features_list item=feature}
					{if ($feature.description == 'Brand')}
					attributes: {
					brand: '{$feature.variant|default:$feature.value}'
					},
					{/if}
					{/foreach}
					{/if}
					{if $rees46_type}
					recommended_by: '{$rees46_type}',
					{/if}
					item_id: {$product.product_id},
					{if $product.price}
					price: {$product.price},
					{else}
					price: {$product.base_price},
					{/if}
					{if $product.amount > 0}
					is_available: true,
					{else}
					is_available: false,
					{/if}
					categories: [{foreach from=$product.category_ids key=cat_id item=cat name=cats}'{$cat}'{if !$smarty.foreach.cats.last},{/if}{/foreach}],
					name: '{$product.product}',
					url: '{"products.view?product_id=`$product.product_id`"|fn_url}',image_url: '{$product.main_pair.detailed.image_path}'
					}
				REES46.pushData('view', param);
				$("#button_cart_ajax{$product.product_id}").on ("click", function(){
					REES46.pushData('cart', param {if $rees46_type}, null, '{$rees46_type}'{/if});
				});
			});
		{/if}
	{/if}
</script>
{/if}
