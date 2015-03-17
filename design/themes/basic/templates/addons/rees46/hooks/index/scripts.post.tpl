{if $rees46 && $rees46.shop_id != ''}
  <script type="text/javascript">
    function initREES46() {
      $(function () {
        {if $auth.user_id > 0}
					{$short_user_data = $auth.user_id|fn_get_user_short_info}
					REES46.init('{$rees46.shop_id}', { "id":{$auth.user_id|default:'null'}, "email":"{$short_user_data.email|default:''}" });
        {else}
          REES46.init('{$rees46.shop_id}', null);
        {/if}

        if (!String.prototype.format) {
            String.prototype.format = function() {
                var args = arguments;
                return this.replace(/\[(\d+)\]/g, function(match, number) {
                    return typeof args[number] != 'undefined'
                        ? args[number]
                        : match
                        ;
                });
            };
        }

        {if $product}
          document.currentProductId = {$product.product_id};
        {/if}

        {if $cart}
          document.currentCart = '{$cart.products|json_encode}';
          document.currentCart = document.currentCart.replace(/&quot;/g, '"');
          document.currentCart = JSON.parse(document.currentCart);
          var ids = [];

          for(var k in document.currentCart) {
            ids.push(document.currentCart[k].product_id);
          }

          document.currentCart = ids;
        {else}
          document.currentCart = [];
        {/if}

        REES46.addReadyListener(function() {
          var link = document.createElement('link');
          link.setAttribute('rel', 'stylesheet');
          link.setAttribute('type', 'text/css');
          link.setAttribute('href', '//rees46.com/shop_css/{$rees46.shop_id}');
          document.getElementsByTagName('head')[0].appendChild(link);

          {if $runtime.controller == 'products' && $runtime.mode == 'view'}
            {if $product}
              REES46.pushData('view', {
                  item_id: {$product.product_id},
                  price: {$product.base_price},
                  {if $product.amount > 0}
                  is_available: true,
                  {else}
                  is_available: false,
                  {/if}
                  category: {$product.main_category},
                  name: '{$product.product}',
                  url: '{"products.view?product_id=`$product.product_id`"|fn_url}',
                  image_url: '{$product.main_pair.detailed.image_path}'
              });
            {/if}
          {/if}

					var rees46_blocks = $('.rees46'), i = 0;
          var rees46_block_render = function() {
            var recommenderBlock = $(this);
            var recommenderType = recommenderBlock.attr('data-type');
            var recommenderCount = recommenderBlock.attr('data-count');
            var recommenderTitle = recommenderBlock.attr('data-title');
            var categoryId = recommenderBlock.attr('data-category');

            if (recommenderType) {
              REES46.recommend({
                recommender_type: recommenderType,
                category: categoryId,
                item: document.currentProductId,
                cart: document.currentCart
              }, function(ids) {
                if (ids.length == 0) {
									rees46_next_render();
                  return;
                }

								if( recommenderCount <= ids.length ) {

									//Стандартные заголовки
									var recommender_titles = {
										interesting: 'Вам это будет интересно',
										also_bought: 'С этим также покупают',
										similar: 'Похожие товары',
										popular: 'Популярные товары',
										see_also: 'Посмотрите также',
										recently_viewed: 'Вы недавно смотрели'
                  };

									//Отправляем запрос
									$.ceAjax('request', fn_url("rees46.get_info"), {
										data: {
											product_ids: ids,
											recommended_by: recommenderType,
											result_ids: recommenderBlock.attr('id'),
											title: recommenderTitle ? recommenderTitle : recommender_titles[recommenderType]
										},
										callback: function() {

											//Находим все ссылки
											recommenderBlock.find('a').each(function(){
												this.href += (this.href.match(/\?/) ? '&' : '?') + 'recommended_by=' + recommenderType
											});
											rees46_next_render();
										}
									})
								} else {
									rees46_next_render();
								}
              })
            }
          };
					var rees46_next_render = function() {
						if( i < rees46_blocks.length ) {
							rees46_block_render.apply(rees46_blocks.eq(i));
							i++;
						}
					};
					rees46_next_render();
        })
      })
    }

    var script = document.createElement('script');
    script.src = '//cdn.rees46.com/rees46_script2.js';
    script.async = true;
    script.onload = function() {
      initREES46();
    };
    document.getElementsByTagName('head')[0].appendChild(script);
  </script>
{/if}
