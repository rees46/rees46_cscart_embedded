{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">

if (!String.prototype.format) {
    String.prototype.format = function() {
        var args = arguments;
        return this.replace(/\[(\d+)\]/g, function(match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match
                ;
        });
    };
};

window._r46 = {
    init: function() {
        (function(r){
            window.r46=window.r46||function(){
                (r46.q=r46.q||[]).push(arguments);
            };
            var s=document.getElementsByTagName(r)[0],rs=document.createElement(r);
            rs.async=1;
            rs.src='//cdn.rees46.com/v3.js';
            s.parentNode.insertBefore(rs,s);
        })('script');
        r46('init', '{$rees46.shop_id}');

        {if $auth.user_id > 0}
            {$short_user_data = $auth.user_id|fn_get_user_short_info}
            r46('profile', 'set', { "id":{$auth.user_id|default:'null'}, "email":"{$short_user_data.email|default:''}" });
        {/if}
    },
    view: function() {
        {if $product}
            document.currentProductId = {$product.product_id};
        {/if}

        {assign var="_cart_products" value=$smarty.session.cart.products}
        {if $_cart_products}
            {$_cart_products = $_cart_products|array_reverse:true}
            var ids = [];
            {foreach from=$_cart_products key="key" item="cart_product" name="cart_products"}
                ids.push({$cart_product.product_id});
            {/foreach}
            document.currentCart = ids;
        {else}
            document.currentCart = [];
        {/if}

        {if ($runtime.controller == 'products' && $runtime.mode == 'view')}
            {if $product}
                params = {
                    {if $rees46_type}
                    recommended_by: '{$rees46_type}',
                    {/if}
                    id: {$product.product_id},
                    {if $product.price}
                    price: {$product.price},
                    {else}
                    price: {$product.base_price},
                    {/if}
                    {if $product.amount > 0}
                    stock: true,
                    {else}
                    stock: false,
                    {/if}
                    categories: [{foreach from=$product.category_ids key=cat_id item=cat name=cats}'{$cat}'{if !$smarty.foreach.cats.last},{/if}{/foreach}],
                    name: '{$product.product}',
                    url: '{"products.view?product_id=`$product.product_id`"|fn_url}',
                    image: '{$product.main_pair.detailed.image_path}'
                };
                r46('track', 'view', params);
            {/if}
        {/if}
    },
    search: function() {
        {if ($runtime.controller == 'products' && $runtime.mode == 'search')}
            var search_query = '{$search.q}';
            if(search_query) {
                r46('track', 'search', search_query);
            };
        {/if}
    },
    category: function() {
        {if ($runtime.controller == 'categories' && $runtime.mode == 'view') && $category_data.category_id > 0}
        r46('track','category', {$category_data.category_id});
        {/if}
    },
    recommend: function() {        
        var rees46_blocks = $('.rees46'), i = 0;
        var rees46_block_render = function () {
            var recommenderBlock = $(this);
            var recommenderType = recommenderBlock.attr('data-type');
            var recommenderCount = recommenderBlock.attr('data-count');
            var recommenderTitle = recommenderBlock.attr('data-title');
            var categoryId = recommenderBlock.attr('data-category');
            var recommenderOrientation = recommenderBlock.attr('data-orientation');

            if (recommenderType) {
            // Skip see_also if cart is empty
                if(recommenderType == 'see_also' && ( document.currentCart == null || document.currentCart.length == 0 ) ) {
                    return;
                }

                r46('recommend', recommenderType, {
                    {if ($runtime.controller == 'products' && $runtime.mode == 'search')}
                    search_query: '{$search.q}',
                    {/if}
                    category: categoryId,
                    item: document.currentProductId,
                    cart: document.currentCart
                }, function(ids){
                    if (ids.length == 0) {
                        rees46_next_render();
                        return;
                    }
                    if (recommenderCount <= ids.length) {
                    //Стандартные заголовки
                        var recommender_titles = {
                            interesting: 'Вам это будет интересно',
                            also_bought: 'С этим также покупают',
                            similar: 'Похожие товары',
                            popular: 'Популярные товары',
                            see_also: 'Посмотрите также',
                            recently_viewed: 'Вы недавно смотрели',
                            buying_now: 'Сейчас покупают',
                            search: 'Искавшие это также купили'
                        };

                        //Отправляем запрос
                        $.ceAjax('request', fn_url("rees46.get_info"), {
                            data: {
                                product_ids: ids,
                                recommended_by: recommenderType,
                                result_ids: recommenderBlock.attr('id'),
                                title: recommenderTitle ? recommenderTitle : recommender_titles[recommenderType],
                                count: recommenderCount,
                                orientation: recommenderOrientation
                            }, callback: function () { //Находим все ссылки
                                recommenderBlock.find('a').each(function () {
                                    this.href += (this.href.match(/\?/) ? '&' : '?') + 'recommended_by=' + recommenderType
                                });
                                rees46_next_render();
                            };
                        });
                    } else {
                        rees46_next_render();
                    };
                });
            };
        };
        var rees46_next_render = function() {
            if( i < rees46_blocks.length ) {
                rees46_block_render.apply(rees46_blocks.eq(i));
                i++;
            };
        };
        rees46_next_render();
    };
};
_r46.init();
_r46.view();
_r46.search();
_r46.category();

var getRecommend = function () {
    var pageIsReady = setInterval(function() {
        if (typeof jQuery != 'undefined') {
            clearInterval(pageIsReady);
            _r46.recommend();
        };
    }, 100);
};
   
var isREES46InitializationStarted = false;
if ( document.readyState === "complete" ) {
    isREES46InitializationStarted = true;
    getRecommend();
} else if ( document.addEventListener ) {
    document.addEventListener( "DOMContentLoaded", function(){
        if(isREES46InitializationStarted == false) {
            getRecommend();
            isREES46InitializationStarted = true;
        };
    });
    window.addEventListener( "load", function(){
        if(isREES46InitializationStarted == false) {
            getRecommend();
            isREES46InitializationStarted = true;
        };
    });
} else {
    window.attachEvent( "onload", function(){
        if(isREES46InitializationStarted == false) {
            getRecommend();
            isREES46InitializationStarted = true;
        };
    });
};
</script>
{/if}
