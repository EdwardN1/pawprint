<?php

    add_action('add_meta_boxes' , 'pic_product_metabox');

    function pic_product_metabox(){

        add_meta_box(
            'pic_product_date_range',
            'Date Range',
            'pic_product_metabox_callback',
            'product',
            'side',
            'default'
        );

    }

    function pic_product_metabox_callback($post){

        $monthsSelected = get_post_meta($_GET['post'] , '_months' , true);

        $months = array(
                1 => 'January' ,
                2 => 'February' ,
                3 => 'March' ,
                4 => 'April' ,
                5 => 'May' ,
                6 => 'June' ,
                7 => 'July' ,
                8 => 'August' ,
                9 => 'September' ,
                10 => 'October' ,
                11 => 'November' ,
                12 => 'December'
        );

        ?>

        Availiable Months:
        <select name="_months[]" id="" multiple class="widefat form-control">
            <?php 
                foreach($months as $key => $month){
                    if(in_array($key , $monthsSelected)){
                        echo '<option selected value="'.$key.'">'.$month.'</option>';
                    }else{
                        echo '<option value="'.$key.'">'.$month.'</option>';
                    }
                }
            ?>
        </select>

        <?php

    }

?>