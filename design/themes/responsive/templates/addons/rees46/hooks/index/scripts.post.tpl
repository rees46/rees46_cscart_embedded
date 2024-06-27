{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">

{literal}
({
    api: "//api.rees46.ru",
    cdn: "//cdn.rees46.ru",
    currentProductId: null,
    Init: function() {

        window["r46"]=window["r46"]||function(){(r46.q=r46.q||[]).push(arguments)};
        var scriptFile = this.cdn + "/v3.js";

        var pre = document.createElement("link");
        pre.setAttribute("href", this.cdn);
        pre.setAttribute("rel", "dns-prefetch");
        document.head.appendChild(pre);

        pre = document.createElement("link");
        pre.setAttribute("href", this.api);
        pre.setAttribute("rel", "dns-prefetch");
        document.head.appendChild(pre);

        pre = document.createElement("link");
        pre.setAttribute("href", this.cdn);
        pre.setAttribute("rel", "preconnect");
        document.head.appendChild(pre);

        pre = document.createElement("link");
        pre.setAttribute("href", this.api);
        pre.setAttribute("rel", "preconnect");
        document.head.appendChild(pre);

        pre = document.createElement("link");
        pre.setAttribute("href", scriptFile);
        pre.setAttribute("rel", "preload");
        pre.setAttribute("as", "script");
        document.head.appendChild(pre);

        pre = document.createElement("script");
        pre.setAttribute("src", scriptFile),
        pre.setAttribute("async", ""),
        document.head.appendChild(pre);

        r46("init", "{/literal}{$rees46.shop_id}{literal}");

        {/literal}
        {if $auth.user_id > 0}
            {$short_user_data = $auth.user_id|fn_get_user_short_info}
            r46("profile", "set", { "id":"{$auth.user_id|default:'null'}", "email":"{$short_user_data.email|default:''}" });
        {/if}
        {literal}
    },

    Tracking: function() {
        {/literal}
        {if ($runtime.controller == "products" && $runtime.mode == "view") && $product}
            this.currentProductId = {$product.product_id};
            var params = {
                {if $rees46_type}
                recommended_by: "{$rees46_type}",
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
                name: "{$product.product}",
                url: '{"products.view?product_id=`$product.product_id`"|fn_url}',
                image: "{$product.main_pair.detailed.image_path}"
            };
            r46("track", "view", params);
        {/if}
        {if ($runtime.controller == "products" && $runtime.mode == "search")}
            var search_query = "{$search.q}";
            if (search_query.length > 0) {
                r46("track", "search", search_query);
            };
        {/if}
        {if ($runtime.controller == "categories" && $runtime.mode == "view") && $category_data.category_id > 0}
            r46("track", "category", {$category_data.category_id});
        {/if}
        {literal}
    },

    Recommend: function() {
        var self = this;
        var rees46_blocks = $(".rees46"), i = 0;
        var rees46_block_render = function () {
            var recommenderBlock = $(this);
            var recommenderType = "dynamic";
            var recommenderCode = $.trim(recommenderBlock.attr("rees46-data-code"));
            var categoryId = recommenderBlock.attr("rees46-data-category");
            var recommenderOrientation = recommenderBlock.attr("rees46-data-orientation");
            var productsPerLine = recommenderBlock.attr("rees46-data-perline");

            if (recommenderCode) {
                r46("recommend", recommenderCode, {
                    {/literal}
                    {if ($runtime.controller == "products" && $runtime.mode == "search")}
                    search_query: "{$search.q}",
                    {/if}
                    {literal}
                    category: categoryId,
                    item: self.currentProductId
                }, function(data) {
                    if (data && data.hasOwnProperty("recommends") && data.recommends.length > 0) {
                        var ids = data.recommends;
                        recommenderTitle = data.title;

                        $.ceAjax("request", fn_url("rees46.get_info"), {
                            data: {
                                product_ids: ids,
                                recommended_by: recommenderType,
                                recommended_code: recommenderCode,
                                title: recommenderTitle,
                                result_ids: recommenderBlock.attr("id"),
                                orientation: recommenderOrientation,
                                products_perline: productsPerLine
                            }, callback: function () {
                                recommenderBlock.find('a').each(function () {
                                    this.href += (this.href.match(/\?/) ? '&' : '?') + 'recommended_by=' + recommenderType + '&recommended_code=' + recommenderCode
                                });
                                rees46_next_render();
                            }
                        });

                    } else {
                        rees46_next_render();
                    }
                });
            }
        };
        var rees46_next_render = function() {
            if( i < rees46_blocks.length ) {
                rees46_block_render.apply(rees46_blocks.eq(i));
                i++;
            }
        };
        rees46_next_render();
    },

    AddInstantSearch: function() {
        {/literal}
        {if $rees46.instant_search }
        $("#search_input").addClass("rees46-instant-search");
        r46("search_init", ".rees46-instant-search");
        {/if}
        {literal}
    },

    jQuery: function(callback) {
        if (typeof callback != "function") return;
        if (typeof jQuery != "undefined") {
            callback();
        } else {
            var ready = setInterval(function() {
                if (typeof jQuery != "undefined") {
                    clearInterval(ready);
                    callback();
                }
            }, 100);
        }
    },

    AfterDocumentReady: function() {
        var Ready = function() {
            this.jQuery(this.AddInstantSearch.bind(this));
            this.jQuery(this.Recommend.bind(this));
        }.bind(this);
        if (document.readyState == "interactive" || document.readyState == "complete") {
            Ready();
        } else {
            document.addEventListener("DOMContentLoaded", function() {
                Ready();
            })
        }
    },

    REES46: function() {
        this.Init();
        this.Tracking();
        this.AfterDocumentReady();
    }
}).REES46();
{/literal}

</script>
{/if}
