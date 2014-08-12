{if $rees46}
    {if $product}
        <script>
            $(function() {
                REES46.addReadyListener(function() {
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
                });
            });
        </script>
    {/if}
{/if}
