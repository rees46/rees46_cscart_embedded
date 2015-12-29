{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
	{if $product}
		{$features=$product.header_features}
		{if $features}
			{foreach from=$features key=feature_id item=feature}
			{$feature_desc = $feature.description|lower}
			{if ($feature_desc == 'brand') || 
			    ($feature_desc == 'vendor') || 
			    ($feature_desc == 'бренд') || 
			    ($feature_desc == 'брэнд') ||
			    ($feature_desc == 'производитель') || 
			    ($feature_desc == 'торговая марка') ||
			    ($feature_desc == 'вендор')}
			{$brand = $feature.variant|default:$feature.value}
			{/if}
			{if ($feature.description|lower == 'gender') || 
			    ($feature.description|lower == 'пол')}
				{$genders = $feature.variant|default:$feature.value|lower}
				{if $genders == 'female' ||
				    $genders|mb_substr:0:5 == 'женск'}
					{$gender = 'f'}
				{elseif $feature.variant|default:$feature.value|lower == 'male' ||
					$feature.variant|default:$feature.value|lower|mb_substr:0:5 == 'мужск'}
					{$gender = 'm'}
				{/if}
			{/if}
			{/foreach}
		{/if}
		{if !$gender}
			{$features=$product.product_features}
			{if $features}
				{foreach from=$features key=feature_id item=feature}
				{if ($feature.description|lower == 'gender') || 
				    ($feature.description|lower == 'пол')}
					{$feature_item = $feature.variant_id}
					{if $feature_item}
						{$genders = $feature.variants.$feature_item.variant|lower}
						{if $genders == 'female' ||
						    $genders|mb_substr:0:5 == 'женск'}
							{$gender = 'f'}
						{elseif $genders == 'male' ||
							$genders|mb_substr:0:5 == 'мужск'}
							{$gender = 'm'}
						{/if}
					{/if}

				{/if}
				{/foreach}
			{/if}
		{/if}
		{$options=$product.selected_options}
		{foreach from=$options key=option_id item=option}
			{$option_name=$product.product_options.$option_id.option_name|lower}
			{if $option_name == 'size' || $option_name|mb_substr:0:6 == 'размер'}
				{$variant_name=$product.product_options.$option_id.variants.$option.variant_name|lower}
				{if $variant_name == 'xx small' || $variant_name == 'xxs'}{$sizes="`XXS`"}{/if}
				{if $variant_name == 'x small' || $variant_name == 'xs'}{$sizes="`XS`"}{/if}
				{if $variant_name == 'small' || $variant_name == 's'}{$sizes="`S`"}{/if}
				{if $variant_name == 'medium' || $variant_name == 'm'}{$sizes="`M`"}{/if}
				{if $variant_name == 'large' || $variant_name == 'l'}{$sizes="`L`"}{/if}
				{if $variant_name == 'x large' || $variant_name == 'xl'}{$sizes="`XL`"}{/if}
				{if $variant_name == 'xx large' || $variant_name == 'xxl'}{$sizes="`XXL`"}{/if}
				{if $variant_name == 'xxx large' || $variant_name == 'xxxl'}{$sizes="`XXXL`"}{/if}
			{/if}
		{/foreach}
		cart_param = {
			{if $gender || $sizes}
				attributes: {
					fashion: {
						{if $gender}gender: '{$gender}',{/if}
						{if $sizes}sizes: [{$sizes}],{/if}
						{if $brand}brand: '{$brand}'{/if}
					}
				},
			{elseif $brand}
				brand: '{$brand}',
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
			url: '{"products.view?product_id=`$product.product_id`"|fn_url}',
			image_url: '{$product.main_pair.detailed.image_path}'
		}

		if ($("#button_cart_ajax{$product.product_id}").length>0) {

			$("#button_cart_ajax{$product.product_id}").on ("click", function(){
			        REES46.addReadyListener(function() {
					REES46.pushData('cart', cart_param{if $rees46_type}, null, '{$rees46_type}'{/if});
				});
			});
		} else {
			$("{if $rees46_type}#rees46_recommend_{$rees46_type}{/if} #button_cart_{$product.product_id}").on ("click", function(){
			        REES46.addReadyListener(function() {
					REES46.pushData('cart', cart_param);
				});
			});
		}

	{/if}
</script>
{/if}
