{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
    {if $cart}
        {capture assign="r46_cart"}{$cart.products|json_encode:8 nofilter}{/capture}
        {capture assign="r46_cart"}{$r46_cart|replace:'\u0022':'' nofilter}{/capture}
        {literal}
        (function() {
            var cart = '{/literal}{$r46_cart nofilter}{literal}';
            cart = JSON.parse(cart.replace(/\s{2,}/g, ' '));
            $("a.ty-cart-content__product-delete").each(function(key, value) {
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
            });
        })();
        {/literal}
    {/if}
</script>
{/if}
