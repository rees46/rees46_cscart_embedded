﻿{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
	{if $cart}
		cart = '{$cart.products|json_encode}';
		{literal}
		cart = cart.replace(/&quot;/g, "'");
		cart = cart.replace(/('([{}:,\[\]]))(?=\s)/g, '&quot;$2');
		cart = cart.replace(/'(?=[:,}\]])/g, '"');
		cart = cart.replace(/([{:,\[])'/g, '$1"');
		cart = cart.replace(/'/g, '&quot;');
		cart = JSON.parse(cart);
		{/literal}
		$("a.ty-cart-content__product-delete").each(function(b,a){
		    r=new RegExp('cart_id=([0-9]+)','g');
		    cid=a.href.match(r);
		    if(cid){
		        cid=cid[0].split('=')[1];
		        $(this).on("click",function(){
		            cid=this.href.match(r)[0].split('=')[1];
		            if(cart[cid]){
		                d=cart[cid];
		                REES46.addReadyListener(function(){
		                    REES46.pushData('remove_from_cart', {
		                        item_id:d.product_id,
		                        price:d.price,
		                        is_available:true,
		                        categories:d.category_ids
		                    });
		                });
		            }
		        });
		    }
		});
	{/if}
</script>
{/if}
