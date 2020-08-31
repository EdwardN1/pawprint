<div class="ppf_side_order_review">

</div>

<script>
    $ = jQuery;
    function update_order_review(){

        var data = {
            action : 'get_order_review'
        };

        $.post(wc_add_to_cart_params.ajax_url , data , function (res) {
            $('.ppf_side_order_review').html(res);
        });

    }
    update_order_review();
    $('body').on('click' , '.wpmc-nav-button' , function () {
        update_order_review();
        console.log('Hello');
    });
</script>