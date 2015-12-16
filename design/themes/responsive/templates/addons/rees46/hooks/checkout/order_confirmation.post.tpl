{if $rees46 && $rees46.shop_id != ''}
<script type="text/javascript">
	order_info = '{$order_info|json_encode}';
	order_info = order_info.replace(/&quot;/g, '"');
	order_info = order_info.replace(/"\s+(?![\s*"{}:,[]])/g, '&quote;');
	order_info = JSON.parse(order_info);
	window.onload = function () {
		param = [];
		$.each (order_info.products, function(a, b){
			param.push ({
				item_id: b.product_id,
				price: b.price,
				is_available: true,
				amount: b.amount
			});
		});	
		REES46.addReadyListener(function () {
			REES46.pushData('purchase', param, order_info['order_id']);
		});
	};
</script>
{/if}

