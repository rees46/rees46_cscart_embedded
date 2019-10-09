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
        $('a.cm-ajax').each(function(b, a){
            r = new RegExp('cart_id=([0-9]+)','g');
            cid = a.href.match(r);
            if(cid) {
                cid = cid[0].split('=')[1];
                $(this).on("click",function() {
                    cid = this.href.match(r)[0].split('=')[1];
                    if(cart[cid]) {
                        d = cart[cid];
                        r46('track', 'remove_from_cart', d.product_id);
                    }
                })
            }
        })
    })();
    {/literal}
{/if}
</script>
{/if}
