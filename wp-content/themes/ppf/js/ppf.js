( function( $ ) {

    $('body').on('click' , '.quantity_control_btn' , function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();

        var action = $(this).data('action');
        var qty = $(this).parents('.quantity').find('input').val();
        qty = parseFloat(qty);

        if(qty != 1){

            if(action == 'minus'){
                qty = qty - 1;
            }

        }

        if(action == 'add'){
            qty = qty + 1;
        }

        $('button[name="update_cart"]').prop('disabled' , false);

        $(this).parents('.quantity').find('input').val(qty);

    });

    $('.ppf_side_order_review').insertAfter('.wpmc-step-login');


    $('body').on('click' , '.faq-accordian .question' , function () {

        $(this).parent().find('.answer').slideUp();
        $(this).parent().find('.question').removeClass('open');
        $(this).find('.answer').slideDown();
        $(this).addClass('open');

    });

    $('body').on('click' , '.save-to-challenge-pack-toggle' , function () {

        var activity_id = $(this).data('activity-id');

        var data = {
            action: 'pp_add_activity_popup',
            activity_id: activity_id
        };

        $.post(wc_add_to_cart_params.ajax_url , data , function (res) {
            $(res).insertAfter('header#masthead');
            $('body .activity-add-to-pack-popup').fadeIn();
            $('body .activity-add-to-pack-popup .vert').height($('body .activity-add-to-pack-popup').height()).width($('body .activity-add-to-pack-popup').width());
        });

    });

    $('body').on('click' , '.activity-add-to-pack-popup .close-button' , function () {
        $('body .activity-add-to-pack-popup').fadeOut();
        setTimeout(function () {
            $('body .activity-add-to-pack-popup').remove();
        } , 500);
    });

    $('body').on('submit' , '#add_to_challengepack' , function () {

        var data = {
            action: 'pp_add_activity_challenge_pack',
            activity_id: $(this).find('input[name="activity_id"]').val(),
            pack: $(this).find('select[name="_pack"]').val(),
        }

        $.post(wc_add_to_cart_params.ajax_url , data , function (res) {
            var json = JSON.parse(res);
            if(json.code == 200){
                $('body .activity-add-to-pack-popup .success-msg').fadeIn();
                setTimeout(function () {
                    $('body .activity-add-to-pack-popup .close-button').click();
                } , 10000);
            }
        });

        return false;

    });

    $('body .menu-dropdown').each(function (index , element) {
        $(element).find('.right').css('min-height' , $(element).find('.left').height());
    });

    $('.latest-carousel').owlCarousel({
        items: 2,
        autoplay: true,
        loop: true,
        autoplayTimeout: 4000,
        smartSpeed: 1000,
        nav: true,
        responsive: {
            0:{
                nav: true
            }
        }
    });

    $('body').on('change' , '#trails-search-form select[name="_trail"]' , function () {

        var data = {
            action: 'pp_trails_extras',
            trail: $(this).val()
        };

        $('.extend-activities ul').empty();

        $.post(wc_add_to_cart_params.ajax_url , data , function (res) {
            var json = JSON.parse(res);
            console.log(json);
            $('.extend-adventure').show();
            $('body .extend-activities ul').html(json.activities);
            $('body .extend-products ul').html(json.products);
        });


    });

    $('body').on('submit' , '#trails-search-form' , function () {

        if($('body #trails-search-form select[name="_trail"]').val() == null){

            alert('Please select a trail');

        }else{

            var data = {
                action: 'pp_trails_validate_uid',
                uid: $('body #trails-search-form input[name="_uid"]').val(),
                trail: $('body #trails-search-form select[name="_trail"]').val()
            };

            $.post(wc_add_to_cart_params.ajax_url , data , function (res) {
                var json = JSON.parse(res);
                console.log(json);

                $('body .trails-search-form-response').empty();
                $('.trails-search-form-errors').empty();

                if(json.code == 200){

                    var data2 = {
                        action: 'pp_trails_create_questions_html',
                        json: json
                    };

                    $.post(wc_add_to_cart_params.ajax_url , data2 , function (res) {
                        $('body .trails-search-form-response').html(res);
                    });

                }else{

                    for(var i = 0; i < json.errors.length; i++){
                        $('.trails-search-form-errors').append('<p>'+json.errors[i]+'</p>');
                    }

                }

            });

        }

        return false;

    });

    $('.product_read_more').toggle(function () {
        $(this).parent().prev().slideDown();
        $(this).html('Read Less');
    } , function () {
        $(this).parent().prev().slideUp();
        $(this).html('Read More');
    });

    $('body').on('submit' , '#trail-questions-form' , function () {

        var data = {
            action : 'pp_trails_questions_validate',
            questions: {},
            treats: $(this).find('input[name="treats"]').val(),
            group: $(this).find('input[name="group_id"]').val(),
            trail: $('body #trails-search-form select[name="_trail"]').val()
        };

        $('body input[name="question[]"]').each(function (index , element) {
            var id = $(this).data('question-id');
            var val = $(this).val();
            data.questions[id] = val;
        });

        $('.trails-search-form-response-content-errors').empty();
        $('.trails-questions-success').empty();

        $.post(wc_add_to_cart_params.ajax_url , data , function (res) {

            var json = JSON.parse(res);

            if(json.code == 400){

                for(var i = 0; i < json.errors.length; i++){
                    $('.trails-search-form-response-content-errors').append('<p>'+json.errors[i]+'</p>');
                }

            }else{

                $('.trails-questions-success').html(json.html);

                var updateData = {
                    action: 'pp_trails_mark_uid_as_used',
                    uid: $('body #trails-search-form input[name="_uid"]').val(),
                    trail: $('body #trails-search-form select[name="_trail"]').val(),
                    questions: {},
                    treats: $('body #trail-questions-form').find('input[name="treats"]').val(),
                    group: $('body #trail-questions-form').find('input[name="group_id"]').val(),
                };

                $('body input[name="question[]"]').each(function (index , element) {
                    var id = $(this).data('question-id');
                    var val = $(this).val();
                    updateData.questions[id] = val;
                });

                $.post(wc_add_to_cart_params.ajax_url , updateData , function (res) {

                });

            }

        });

        return false;

    });

    $('body').on('click' , '.region_map path' ,function () {

        var region = $(this).data('region');
        console.log(region);

    });

    $('body .region_map path').each(function (index , element) {

        var ele = $(element);
        var fill = ele.css('fill');
        ele.attr('data-color' , fill);

    });

    $('body .region_map path').toggle(function () {

        $('body .region_map path').each(function (index , element) {
            $(element).css('fill' , '#eee');
        });

        $(this).css('fill' , $(this).data('color'));

        var data = {
            action: 'get_trails_by_region',
            region: $(this).data('region'),
            color: $(this).data('color')
        };

        $.post(wc_add_to_cart_params.ajax_url , data , function (res) {
            var json = JSON.parse(res);
            $('body .trails_map_results').css('background' , json.colour);
            $('body .trails_map_results .region').html('<h2>'+json.region+'</h2>')
            console.log(json);
        });

    },function () {

        $('body .region_map path').each(function (index , element) {
            $(element).css('fill' , $(element).data('color'));
        });

    });

    if($(window).width() <= 725){

        $('body li.has-dropdown > a').click(function (e) {

            e.preventDefault();
            e.stopImmediatePropagation();
            $(this).parent().find('.menu-dropdown').slideToggle();

        });

        $('.badge-actions').insertAfter('.description + p');

    }

    $('body .mobile_menu_toggle').click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $('header #site-navigation').toggleClass('moved');
    });

    $('body .menu-dropdown ul li a').each(function (index , element) {

        var ele = $(element);
        var ahtml = ele.html();

        ele.html('<span>'+ahtml+'</span>');

    });

    $('button[name="update_cart"]').click(function () {

        setTimeout(function () {
            $('.shop_table .cart_item').each(function (index , element) {
                var ele = $(element);
                var remove  = ele.find('.product-remove');
                var subtotal = ele.find('.product-subtotal');
                remove.insertAfter(subtotal);
            });
        } , 100);

    });

    $('.shipping-date').insertAfter('.stock');

    $('.woocommerce-additional-fields').insertAfter('#order_review');

    $('body #order_review_heading').html('Additional Information');

    $('.filter_mobile_toggle').click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $(this).next().slideToggle();
    });

    if($(window).width() <= 425){

        $('.page-banner > .vc_column_container:nth-child(2)').appendTo('.banner_part_2');

        $('.activity-detail').insertBefore('.left-section');
        $('.activity_actions').insertBefore('.activity-detail');

    }else{

        $('body .has-dropdown').each(function (index , element) {

            var ele = $(element);
            var linkWidth = $(element).width();

            ele.find('.left').width(linkWidth);

            ele.find('.menu-dropdown').width(linkWidth+400);

        });

    }

    $('body .woocommerce-MyAccount-navigation-link').each(function (index , element) {

        var ele = $(element);

        if(ele.hasClass('woocommerce-MyAccount-navigation-link--edit-account')){

            ele.find('a').append('<small>Change your account details</small>');
            var ahtml = ele.find('a').html();
            ele.find('a').html('<img src="https://pawprintfamily.com/wp-content/uploads/2020/03/account-icons-account.png">'+ahtml);

        }else if(ele.hasClass('woocommerce-MyAccount-navigation-link--orders')){

            ele.find('a').append('<small>Track your recent orders</small>');
            var ahtml = ele.find('a').html();
            ele.find('a').html('<img src="https://pawprintfamily.com/wp-content/uploads/2020/03/account-icons-orders.png">'+ahtml);

        }else if(ele.hasClass('woocommerce-MyAccount-navigation-link--packs')){

            ele.find('a').append('<small>Add new or edit existing custom challenge packs</small>');
            var ahtml = ele.find('a').html();
            ele.find('a').html('<img src="https://pawprintfamily.com/wp-content/uploads/2020/03/account-icons-packs.png">'+ahtml);

        }else if(ele.hasClass('woocommerce-MyAccount-navigation-link--edit-address')){

            ele.find('a').append('<small>Edit your saved accounts</small>');
            var ahtml = ele.find('a').html();
            ele.find('a').html('<img src="https://pawprintfamily.com/wp-content/uploads/2020/03/account-icons-profile.png">'+ahtml);

        }

    });

    $('body .stories-block a').toggle(function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();

        $(this).parents('p').prev('blockquote').show();
        $(this).html('Read Less');

    },function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();

        $(this).parents('p').prev('blockquote').hide();
        $(this).html('Read More');

    });

    var passwordMeter = '<div class="password_meter">' +
                            '<div data-strength="week"><span>Week</span></div>' +
                            '<div data-strength="okay"><span>Okay</span></div>' +
                            '<div data-strength="strong"><span>Strong</span></div>' +
                            '<div data-strength="v-strong"><span>Very Strong</span></div>' +
                        '</div>';
    $(passwordMeter).insertAfter('body .fieldset--password');

    $('body input[name="password"]').keyup(function () {

        var password = $(this).val();
        var strength=0;

        if (password.match(/[a-z]+/)){
            strength+=1;
        }
        if (password.match(/[A-Z]+/)){
            strength+=1;
        }
        if (password.match(/[0-9]+/)){
            strength+=1;
        }
        if (password.match(/[$@#&!]+/)){
            strength+=1;
        }

        console.log(strength);

        if(strength == 1){
            $('body .password_meter').attr('data-strength' , 'week');
        }else if(strength == 2){
            $('body .password_meter').attr('data-strength' , 'okay');
        }else if(strength == 3){
            $('body .password_meter').attr('data-strength' , 'strong');
        }else if(strength == 4){
            $('body .password_meter').attr('data-strength' , 'v-strong');
        }

    });

} )( jQuery );