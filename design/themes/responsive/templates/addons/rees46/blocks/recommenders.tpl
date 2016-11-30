<div  class="rees46 rees46-recommend" data-orientation="{$block.properties.rees46_recommender_orientation}" data-category="{if $category_data}{$category_data.category_id}{/if}" data-type="{$block.properties.rees46_recommender_type}" data-title="{$block.properties.rees46_recommender_title}" data-count="{$block.properties.rees46_items_count}" id="rees46_recommend_{$rees46_type|default:$block.properties.rees46_recommender_type}">
{if $rees46_block_orientation && $rees46_block_orientation == "vertical"}
    {$rees46_template="blocks/list_templates/small_items.tpl"}
{else}
    {$rees46_template="blocks/list_templates/grid_list.tpl"}
{/if}
{if $rees46_products}
    {if $rees46_title}
        <h1>{$rees46_title}</h1>
    {/if}
    {include file=$rees46_template
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
    columns={$rees46_count|default:4}
    no_pagination=true
    show_discount_label=true}
{/if}
<!--rees46_recommend_{$rees46_type|default:$block.properties.rees46_recommender_type}--></div>