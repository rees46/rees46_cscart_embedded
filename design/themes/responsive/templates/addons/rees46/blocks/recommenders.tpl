<div  class="rees46 rees46-recommend" rees46-data-orientation="{$block.properties.rees46_recommender_orientation}" {if $category_data}rees46-data-category="{$category_data.category_id}"{/if} rees46-data-code="{$rees46_code|default:$block.properties.rees46_recommender_code|trim}" id="rees46_recommend_{$rees46_code|default:$block.properties.rees46_recommender_code|trim}">
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
<!--rees46_recommend_{$rees46_code|default:$block.properties.rees46_recommender_code}--></div>