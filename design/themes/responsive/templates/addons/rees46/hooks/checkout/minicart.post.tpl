{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
{if $_cart_products}
    {literal}
    (function() {
        var cart = {};
        {/literal}
        {foreach from=$_cart_products key="key" item="cart_product" name="cart_products"}
        cart['{$key}'] = {
            product_id: {$cart_product.product_id},
        };
        {/foreach}
        {literal}
        $('a.cm-ajax').each(function(key, value){
            var pattern = new RegExp('cart_id=([0-9]+)','g');
            if (pattern.test(value.href)) {
                $(this).on("click",function() {
                    var cid = this.href.match(pattern)[0].split('=')[1];
                    if (cart[cid]) {
                        var id = cart[cid];
                        r46('track', 'remove_from_cart', id.product_id);
                    }
                })
            }
        })
    })();
    {/literal}
{/if}
</script>
{/if}
