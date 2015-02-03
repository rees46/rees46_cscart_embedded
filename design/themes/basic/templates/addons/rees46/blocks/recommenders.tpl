<div class="rees46 rees46-recommend" data-type="recently_viewed" id="my_rees46_div">
{if $rees46_products}
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
{/if}
<!--my_rees46_div--></div>