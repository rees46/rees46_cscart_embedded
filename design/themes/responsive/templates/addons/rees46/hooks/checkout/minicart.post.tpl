{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
{if $_cart_products}
	cart = {};
	{foreach from=$_cart_products key="key" item="product" name="cart_products"}
		cart['{$key}'] = {
				product_id: {$product.product_id},
				price: {$product.price},
				category_ids: [{foreach from=$product.category_ids key=cat_id item=cat name=cats}{$cat}{if !$smarty.foreach.cats.last},{/if}{/foreach}]
				};
	{/foreach}
	$('a.cm-ajax').each(function (b,a){
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
