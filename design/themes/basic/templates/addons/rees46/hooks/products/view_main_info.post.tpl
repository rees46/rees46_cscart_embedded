{if $product}
    <script>
        $(function() {
            REES46.addReadyListener(function() {
                REES46.pushData('view', {
                    item_id: {$product.product_id},
                    price: {$product.base_price},
                    //is_available: '',
                    category: {$product.main_category},
                    //locations: '',
                    name: '{$product.product}',
                    //description: '',
                    //url: '',
                    image_url: '{$product.main_pair.detailed.image_path}'
                    //tags: ''
                });
            });
        });
    </script>
{/if}
