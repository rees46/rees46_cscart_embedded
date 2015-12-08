{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
	{if ($runtime.controller == 'products' && $runtime.mode == 'quick_view')}
		{if $product}
			REES46.pushData('view', {
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
				url: '{"products.view?product_id=`$product.product_id`"|fn_url}',
				image_url: '{$product.main_pair.detailed.image_path}'
			});
		{/if}
	{/if}
</script>
{/if}
