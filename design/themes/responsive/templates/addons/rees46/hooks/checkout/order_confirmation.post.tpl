{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
    order_info = '{$order_info|json_encode}';
    {literal}
    order_info = order_info.replace(/\s/g, " ");
    order_info = order_info.replace(/&quot;/g, "'");
    order_info = order_info.replace(/('([{}:,\[\]]))(?=\s)/g, '&quot;$2');
    order_info = order_info.replace(/'(?=[:,}\]])/g, '"');
    order_info = order_info.replace(/([{:,\[])'/g, '$1"');
    order_info = order_info.replace(/'/g, '&quot;');
    order_info = JSON.parse(order_info);
    window.onload = function () {
        products = [];
        $.each (order_info.products, function(a, b){
            products.push ({
                id: b.product_id,
                price: b.price,
                amount: b.amount
            });
        });
        user_info = {};
        if (typeof order_info.user_id != 'undefined' && order_info.user_id != '') {
            user_info.id = order_info.user_id;
        }
        if (typeof order_info.email != 'undefined') {
            var email = order_info.email.trim();
            var pattern=/^([\w-]+(?:.[\w-]+)*)@((?:[\w-]+.)*\w[\w-]{0,66}).([a-z]{2,6}(?:.[a-z]{2})?)$/i;
            if (pattern.test(email)){
                user_info.email = email;
            }
        }
        r46('profile', 'set', user_info);
        r46('track', 'purchase', {products: products, order: order_info['order_id'], order_price: order_info['subtotal']});
    };
    {/literal}
</script>
{/if}
