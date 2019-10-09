{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
    {if $cart}
        {literal}
        (function() {
            var cart = '{/literal}{$cart.products|json_encode}{literal}';
            cart = cart.replace(/\s/g, " ");
            cart = cart.replace(/&quot;/g, "'");
            cart = cart.replace(/('([{}:,\[\]]))(?=\s)/g, '&quot;$2');
            cart = cart.replace(/'(?=[:,}\]])/g, '"');
            cart = cart.replace(/([{:,\[])'/g, '$1"');
            cart = cart.replace(/'/g, '&quot;');
            cart = JSON.parse(cart);
            $("a.ty-cart-content__product-delete").each(function(b, a){
                r = new RegExp('cart_id=([0-9]+)','g');
                cid = a.href.match(r);
                if (cid) {
                    cid = cid[0].split('=')[1];
                    $(this).on("click",function() {
                        cid = this.href.match(r)[0].split('=')[1];
                        if (cart[cid]) {
                            d = cart[cid];
                            r46('track', 'remove_from_cart', d.product_id);
                        }
                    })
                }
            });
        })();
        {/literal}
    {/if}
</script>
{/if}
