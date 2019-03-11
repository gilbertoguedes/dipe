<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- ========== Page Header Area ========== -->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('category')?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url()?>"><?php echo display('home')?></a></li>
                <li class="breadcrumb-item active"><?php echo $category_name?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->

<!--========== Product Category  ===========-->
<section class="product_category">
    <div class="container">
        <div class="row product_category_inner container_section">
            <div class="col-lg-3 col-md-5">

                <div class="price_range">
                    <p>
                        <?php echo display('price_range')?>:<span id="amount"></span>
                    </p>
                    <div id="slider-range"></div>
                    <form method="post" action="">
                        <input type="hidden" id="amount1">
                        <input type="hidden" id="amount2">
                    </form>
                </div>

                <?php
                    $default_currency_id =  $this->session->userdata('currency_id');
                    $currency_new_id     =  $this->session->userdata('currency_new_id');

                    if (empty($currency_new_id)) {
                        $result  =  $cur_info = $this->db->select('*')
                                            ->from('currency_info')
                                            ->where('default_status','1')
                                            ->get()
                                            ->row();
                        $currency_new_id = $result->currency_id;
                    }

                    if (!empty($currency_new_id)) {
                        $cur_info = $this->db->select('*')
                                            ->from('currency_info')
                                            ->where('currency_id',$currency_new_id)
                                            ->get()
                                            ->row();

                        $target_con_rate = $cur_info->convertion_rate;
                        $position1 = $cur_info->currency_position;
                        $currency1 = $cur_info->currency_icon;
                    }
                ?>

                <div class="row m0 db bg_gray best_sale">
                    <h4 class="heading-2"><?php echo display('best_sales')?></h4>
                    <?php 
                    $this->db->select('*');
                    $this->db->from('product_information');
                    $this->db->where('best_sale','1');
                    $this->db->where('category_id',$category_id);
                    $this->db->order_by('id','desc');
                    $this->db->limit('6');
                    $query = $this->db->get();
                    $best_category_sale = $query->result();

                    if ($best_category_sale) {
                        foreach ($best_category_sale as $sales) { 
                    ?>
                    <div class="media single_product">
                        <img class="d-flex" src="<?php echo $sales->image_thumb?>" alt="product image">
                        <div class="media-body">
                            <a href="<?php echo base_url('product_details/'.$sales->product_id)?>"><?php echo $sales->product_name?></a>
                            <?php if ($sales->onsale == 1 && !empty($sales->onsale_price)) {?>
                            <div class="product_cost">
                                <p class="current">
                                    <?php
                                        if ($target_con_rate > 1) {
                                            $price = $sales->onsale_price * $target_con_rate;
                                            echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $sales->onsale_price * $target_con_rate;
                                            echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                        }
                                    ?>
                                </p>
                                <p class="previous">

                                   <?php 
                                    if ($target_con_rate > 1) {
                                        $price = $sales->price * $target_con_rate;
                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $price = $sales->price * $target_con_rate;
                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }
                                    ?>
                                </p>
                            </div>
                            <?php }else{ ?>
                            <div class="product_cost">
                                <p class="current">
                                    <?php 
                                        if ($target_con_rate > 1) {
                                            $price = $sales->price * $target_con_rate;
                                            echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $sales->price * $target_con_rate;
                                            echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                        }
                                    ?> 
                                </p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php 
                        } 
                    }
                    ?>
                </div>
                <div class="row m0 db banner_area">
                    <?php
                    if ($select_category_product) {
                        foreach ($select_category_product as $adds) {
                           if ($adds->adv_position == 1) {
                               echo $adds->adv_code;
                           }
                        }
                    }
                    ?>
                </div>
            </div>
            <input type="hidden" name="category_id" id="category_id" value="<?php echo $this->uri->segment(2)?>">
            <div class="col-lg-9 col-md-7">
                <div class="product_inner">
                    <div class="row slider_style">
                        <?php
                        if ($category_wise_product) {
                            foreach ($category_wise_product as $product) {
                        ?>
                        <div class="col-lg-3 col-sm-6 single_product_item">
                            <div class="item item_category">
                                <div class="item_inner">
                                    <div class="item_image">
                                        <a href="<?php echo base_url('product_details/'.$product->product_id)?>">
                                            <img src="<?php echo $product->image_thumb?>" alt="product-image">
                                        </a>
                                    </div>
                                    <div class="item_info">
                                        <h6><?php echo $product->product_name?></h6>
                                        <div class="rating_area">
                                            <div class="rate-container">
                                            <?php
                                                $result = $this->db->select('sum(rate) as rates')
                                                                ->from('product_review')
                                                                ->where('product_id',$product->product_id)
                                                                ->get()
                                                                ->row();

                                                $rater = $this->db->select('rate')
                                                                ->from('product_review')
                                                                ->where('product_id',$product->product_id)
                                                                ->get()
                                                                ->num_rows();

                                                if ($result->rates != null) {
                                                    $total_rate = $result->rates/$rater;
                                                    if (gettype($total_rate) == 'integer') {
                                                        for ($t=1; $t <= $total_rate; $t++) {
                                                           echo "<i class=\"fa fa-star\"></i>";
                                                        }
                                                        for ($tt=$total_rate; $tt < 5; $tt++) { 
                                                            echo "<i class=\"fa fa-star-o\"></i>";
                                                        }
                                                    }elseif (gettype($total_rate) == 'double') {
                                                        $pieces = explode(".", $total_rate);
                                                        for ($q=1; $q <= $pieces[0]; $q++) {
                                                           echo "<i class=\"fa fa-star\"></i>";
                                                           if ($pieces[0] == $q) {
                                                               echo "<i class=\"fa fa-star-half-o\"></i>";
                                                               for ($qq=$pieces[0]; $qq < 4; $qq++) { 
                                                                    echo "<i class=\"fa fa-star-o\"></i>";
                                                                }
                                                           }
                                                        }

                                                    }else{
                                                        for ($w=0; $w <= 4; $w++) {
                                                           echo "<i class=\"fa fa-star-o\"></i>";
                                                        }
                                                    }
                                                }else{
                                                    for ($o=0; $o <= 4; $o++) {
                                                       echo "<i class=\"fa fa-star-o\"></i>";
                                                    }
                                                }
                                            ?>
                                            </div>
                                        </div>
                                        
                                        <?php
                                            $default_currency_id =  $this->session->userdata('currency_id');
                                            $currency_new_id     =  $this->session->userdata('currency_new_id');

                                            if (empty($currency_new_id)) {
                                                $result  =  $cur_info = $this->db->select('*')
                                                                    ->from('currency_info')
                                                                    ->where('default_status','1')
                                                                    ->get()
                                                                    ->row();
                                                $currency_new_id = $result->currency_id;
                                            }

                                            if (!empty($currency_new_id)) {
                                                $cur_info = $this->db->select('*')
                                                                    ->from('currency_info')
                                                                    ->where('currency_id',$currency_new_id)
                                                                    ->get()
                                                                    ->row();

                                                $target_con_rate = $cur_info->convertion_rate;
                                                $position1 = $cur_info->currency_position;
                                                $currency1 = $cur_info->currency_icon;
                                            }
                                        ?>

                                        <?php if ($product->onsale == 1 && !empty($product->onsale_price)) { ?>
                                        <div class="product_cost">
                                            <p class="current">
                                            <?php
                                                if ($target_con_rate > 1) {
                                                    $price = $product->onsale_price * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }

                                                if ($target_con_rate <= 1) {
                                                    $price = $product->onsale_price * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }
                                            ?>
                                            </p>
                                            <p class="previous">
                                            <?php 
                                                if ($target_con_rate > 1) {
                                                    $price = $product->price * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }

                                                if ($target_con_rate <= 1) {
                                                    $price = $product->price * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }
                                            ?>
                                            </p>
                                        </div>
                                        <?php }else{ ?>
                                        <div class="product_cost">
                                            <p class="current">
                                                <?php 
                                                    if ($target_con_rate > 1) {
                                                        $price = $product->price * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }

                                                    if ($target_con_rate <= 1) {
                                                        $price = $product->price * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }
                                                ?>    
                                            </p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="item_hover">
                                        <ul class="nav">
                                            <li>
                                                <a href="#" class="wishlist" name="<?php echo $product->product_id?>"><i class="fa fa-heart"></i></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $product->image_thumb?>" data-lightbox="image-1"><i class="fa fa-search"></i></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url('category_product/'.$product->category_id)?>"><i class="fa fa-arrows"></i></a>
                                            </li>
                                        </ul>
                                        <div class="addtocard">
                                            <form action="" method="post">
                                                <input type="hidden" value="1">
                                                <button type="button" class="cart_button"><?php echo display('add_to_cart')?></button>
                                            </form>
                                        </div>
                                    </div>
                                    <span><?php echo display('new')?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <nav aria-label="page navigation example">
                        <?php echo $links?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== End Product Category ========== -->

<!-- Price range filter start-->
<script type="text/javascript">
    // price range filter
    $( "#slider-range" ).slider({
        range: true,
        min: <?php echo $min_value?>,
        max: <?php echo $max_value?>,
        values: [ <?php echo $min_value?>, <?php echo $max_value?> ],
        slide: function( event, ui ) {
            $( "#amount" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            $( "#amount1" ).val(ui.values[ 0 ]);
            $( "#amount2" ).val(ui.values[ 1 ]);

            var new_min = $( "#amount1" ).val();
            var new_max = $( "#amount2" ).val();
            var category_id = $( "#category_id" ).val();

            $.ajax({
                url: '<?php echo base_url('website/category/category_price_wise_product')?>',
                type: 'post',
                data: {new_min:new_min,new_max:new_max,category_id:category_id},
                success: function(data){
                    $('#category_product').hide(); 
                    $('.slider_style').html(data);
                } 
            });
        }
    });
    
    $( "#amount" ).html( "$" + $( "#slider-range" ).slider( "values", 0 ) +
     " - $" + $( "#slider-range" ).slider( "values", 1 ) );
</script>
<!-- Price range filter end-->

<script type="text/javascript">
    //Add wishlist
    $('body').on('click', '.wishlist', function() {
        var product_id  = $(this).attr('name');
        var customer_id = '<?php echo $this->session->userdata('customer_id')?>';
        if (customer_id == 0) {
            alert('<?php echo display('please_login_first')?>');
            return false;
        }
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/add_wishlist')?>',
            data: {product_id:product_id,customer_id:customer_id},
            success: function(data) {
                if (data == '1') {
                    alert('<?php echo display('product_added_to_wishlist')?>');
                }else if(data == '2'){
                    alert('<?php echo display('product_already_exists_in_wishlist')?>')
                }else if(data == '3'){
                    alert('<?php echo display('please_login_first')?>')
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });   
</script>