{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
{capture assign="r46_order"}{$order_info|json_encode:8 nofilter}{/capture}
{capture assign="r46_order"}{$r46_order|replace:'\u0022':'' nofilter}{/capture}
    {literal}
    (function() {
        var order_info = '{/literal}{$r46_order nofilter}{literal}';
        order_info = JSON.parse(order_info.replace(/\s{2,}/g, ' '));
        document.addEventListener("DOMContentLoaded", function() {
            products = [];
            $.each (order_info.products, function(a, b){
                products.push ({
                    id: b.product_id,
                    price: b.price,
                    amount: b.amount
                });
            });

            var user_info = {};
            if (typeof order_info.user_id != 'undefined' && order_info.user_id != 0 && typeof order_info.email != 'undefined') {
                user_info.id = order_info.user_id;
                var email = order_info.email.trim();
                var pattern=/^([\w-]+(?:.[\w-]+)*)@((?:[\w-]+.)*\w[\w-]{0,66}).([a-z]{2,6}(?:.[a-z]{2})?)$/i;
                if (pattern.test(email)){
                    user_info.email = email;
                }
            };
            Object.keys(user_info).length&&r46('profile', 'set', user_info);
            r46('track', 'purchase', {products: products, order: order_info['order_id'], order_price: order_info['subtotal']});
        });
    })();
    {/literal}
</script>
{/if}
