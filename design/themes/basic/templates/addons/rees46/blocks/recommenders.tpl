<div class="rees46 rees46-recommend" data-category="{if $category_data}{$category_data.category_id}{/if}" data-type="{$block.properties.rees46_recommender_type}" data-title="{$block.properties.rees46_recommender_title}" data-count="{$block.properties.rees46_items_count}" id="rees46_recommend_{$rees46_type|default:$block.properties.rees46_recommender_type}">
{if $rees46_products}
	{if $rees46_title}
		<h1>{$rees46_title}</h1>
	{/if}
	{include file="blocks/list_templates/grid_list.tpl"
	products=$rees46_products
	show_trunc_name=true
	show_old_price=true
	show_price=true
	show_rating=true
	show_clean_price=true
	show_list_discount=true
	show_add_to_cart=$show_add_to_cart|default:false
	but_role="action"
	no_sorting=true
	columns=4
	show_discount_label=true}
	<div class="reed46-promo"></div>
	<script>
		if( REES46 && REES46.showPromotion ) {
			$('.reed46-promo').html(REES46.getPromotionBlock());
		}
	</script>
{/if}
<!--rees46_recommend_{$rees46_type|default:$block.properties.rees46_recommender_type}--></div>