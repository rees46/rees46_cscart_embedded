{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
	{if ($runtime.controller == 'products' && $runtime.mode == 'quick_view')}
		{if $product}
		        REES46.addReadyListener(function() {
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
		{$options=$product.product_options}
		{foreach from=$options key=option_id item=option}
			{$opt_name = $option.option_name|lower}
			{if ($opt_name == 'size') || 
			    ($opt_name|mb_substr:0:6 == 'размер')}
				{$size_items=$option.variants}
				{assign var=sizes value=''}
				{foreach from=$size_items key=variant_id item=size name=sizes_arr}
					{$size_item = $size.variant_name|lower}
					{if $size_item == 'xx small' || $size_item == 'xxs'}{if $sizes}{assign var=sizes value="$sizes, `XXS`"}{else}{assign var=sizes value="`XXS`"}{/if}{/if}
					{if $size_item == 'x small' || $size_item == 'xs'}{if $sizes}{assign var=sizes value="$sizes, `XS`"}{else}{assign var=sizes value="`XS`"}{/if}{/if}
					{if $size_item == 'small' || $size_item == 's'}{if $sizes}{assign var=sizes value="$sizes, `S`"}{else}{assign var=sizes value="`S`"}{/if}{/if}
					{if $size_item == 'medium' || $size_item == 'm'}{if $sizes}{assign var=sizes value="$sizes, `M`"}{else}{assign var=sizes value="`M`"}{/if}{/if}
					{if $size_item == 'large' || $size_item == 'l'}{if $sizes}{assign var=sizes value="$sizes, `L`"}{else}{assign var=sizes value="`L`"}{/if}{/if}
					{if $size_item == 'x large' || $size_item == 'xl'}{if $sizes}{assign var=sizes value="$sizes, `XL`"}{else}{assign var=sizes value="`XL`"}{/if}{/if}
					{if $size_item == 'xx large' || $size_item == 'xxl'}{if $sizes}{assign var=sizes value="$sizes, `XXL`"}{else}{assign var=sizes value="`XXL`"}{/if}{/if}
					{if $size_item == 'xxx large' || $size_item == 'xxxl'}{if $sizes}{assign var=sizes value="$sizes, `XXXL`"}{else}{assign var=sizes value="`XXXL`"}{/if}{/if}
					{if is_numeric($size_item)}{if $sizes}{assign var=sizes value="$sizes, $size_item"}{else}{assign var=sizes value="$size_item"}{/if}{/if}
				{/foreach}
			{/if}
		{/foreach}

		param = {
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
			url: '{"products.view?product_id=`$product.product_id`"|fn_url}',image_url: '{$product.main_pair.detailed.image_path}'
			}		
				REES46.pushData('view', param);
			});
		{/if}
	{/if}
</script>
{/if}
