{if $rees46}
  <script src="//cdn.rees46.com/rees46_script2.js"></script>
  <script type="text/javascript">
      $(function () {
        {if $auth.user_id > 0}
          REES46.init('{$rees46.shop_id}', {$auth.user_id|default:'null'});
        {else}
          REES46.init('{$rees46.shop_id}', null);
        {/if}
      });
  </script>
  <link rel="stylesheet" type="text/css" href="//rees46.com/shop_css/{$rees46.shop_id}">
  <script type="text/javascript">
  $(function () {
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

    REES46.addReadyListener(function() {
      $('.rees46').each(function() {
        var recommenderBlock = $(this);
        var recommenderType = recommenderBlock.attr('data-type');

        var tpl_items = '<div class="recommender-block-title">[1]</div><div class="recommended-items">[0]</div>';
        var tpl_item  = '<div class="recommended-item">'+
                        '<div class="recommended-item-photo">'+
                            '<a href="[0]"><img src="[2]" class="item_img" /></a>'+
                        '</div>'+
                        '<div class="recommended-item-title">'+
                            '<a href="[0]">[1]</a>'+
                        '</div>'+
                        '<div class="recommended-item-price">'+
                            '[3] [4]'+
                        '</div>'+
                        '<div class="recommended-item-action">'+
                            '<a href="[0]">Подробнее</a>'+
                        '</div>'+
                   '</div>';


        if (recommenderType) {
          REES46.recommend({
            recommender_type: recommenderType
          }, function(ids) {
            $.getJSON('index.php?dispatch=rees46.get_info&product_ids=' + ids.join(','), function(data) {
              var products = JSON.parse(data.text).products;

              var productsBlock = '';

              $(products).each(function() {
                productsBlock += tpl_item.format(
                  this.url + '?recommended_by=' + recommenderType,
                  this.name,
                  this.image_url,
                  this.price,
                  REES46.currency
                );
              });

              var recommender_titles = {
                  interesting: 'Вам это будет интересно',
                  also_bought: 'С этим также покупают',
                  similar: 'Похожие товары',
                  popular: 'Популярные товары',
                  see_also: 'Посмотрите также',
                  recently_viewed: 'Вы недавно смотрели'
              };

              items = tpl_items.format(productsBlock, recommender_titles[recommenderType]);
              recommenderBlock.html(items);
            });
          });
        }
      });
    });
  });
  </script>
{/if}
