<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo $category_name?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="#"><?php echo display('category')?></a></li>
                <li class="breadcrumb-item active"><?php echo $category_name?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->

<?php
    if (!(empty($category_product))) {
?>

<!--========== Product Category Area ==========-->
<section class="product_category">
    <div class="container">
        <div class="product_category_inner container_section">
            <div class="product_inner">
                <div class="row m0 slider_style">
                    <?php
                    if ($category_product) {
                        foreach ($category_product as $product) {
                    ?>
                    <div class="col-xl-3 col-lg-4 col-sm-6 single_product_item">
                        <div class="item item_shadow">
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
                                    <!--<li>
                                        <a href="#" class="wishlist" name="<?php echo $product->product_id?>"><i class="fa fa-heart"></i></a>
                                    </li>-->
                                    <li>
                                        <a href="<?php echo $product->image_thumb?>" data-lightbox="image-1"><i class="fa fa-search"></i></a>
                                    </li>
                                    <!--<li>
                                        <a href="<?php echo base_url('category_product/'.$product->category_id)?>"><i class="fa fa-arrows"></i></a>
                                    </li>-->
                                </ul>
                                <div class="addtocard">
                                    <form action="" method="post">
                                        <input type="hidden" id="sst" value="1">
                                        <a href="<?php echo base_url('product_details/'.$product->product_id)?>">
                                            <!--<button type="button" class="cart_button"><?php echo display('add_to_cart')?></button>-->
                                            <button type="button" class="cart_button" ><i class="fa fa-shopping-cart"></i></button>
                                        </a>
                                    </form>
                                </div>
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
</section>
<!--========== End Product Category Area ==========-->
<?php
}else{
?>
<!--========== Category Product Empty ==========-->
<section class="shopping_cart_area">
    <div class="container">
        <div class="row db empty_cart">
            <img src="<?php echo base_url()?>assets/website/image/oops.png" alt="oops image">
            <h2 class="page_title"><?php echo display('category_product_not_found')?></h2>
        </div>
    </div>
</section>
<!--========== Category Product Empty ==========--> 
<?php
}
?>

<!--=========== Newsletter Area ===========-->
<section class="newsletter_area">
    <div class="container">
        <div class="row m0 newsletter_inner bg_gray">
            <div class="col-lg-6 col-xl-5">
                <div class="row m0 newsletter_left_area">
                    <h4><?php echo display('sign_up_for_news_and')?> <span><?php echo display('offers')?></span></h4>
                    <h6><?php echo display('you_may_unsubscribe_at_any_time')?></h6>
                </div>
            </div>
            <div class="col-lg-6 col-xl-7">
                <div id="sub_msg"></div>
                <form action="" class="row m0 newsletter_form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="<?php echo display('enter_your_email')?>" required="" id="sub_email">
                        <span class="input-group-btn">
                            <button class="btn btn-default subscribe" type="button" id="smt_btn"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--========= End Newsletter Area =========-->

<!-- Newsletter ajax code start-->
<script type="text/javascript">
    //Subscribe entry
    $('body').on('click', '#smt_btn', function() {
        var sub_email = $('#sub_email').val();
        if (sub_email == 0) {
            alert('<?php echo display('please_enter_email')?>');
            return false;
        }
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/add_subscribe')?>',
            data: {sub_email:sub_email},
            success: function(data) {
                if (data == '2') {
                    $("#sub_msg").html('<p style="color:green"><?php echo display('subscribe_successfully')?></p>');
                    $('#sub_msg').hide().fadeIn('slow');
                    $('#sub_msg').fadeIn(700);
                    $('#sub_msg').hide().fadeOut(2000);
                    $("#sub_email").val(" ");
                }else{
                    $("#sub_msg").html('<p style="color:red"><?php echo display('failed')?></p>'); 
                    $('#sub_msg').hide().fadeIn('slow');
                    $('#sub_msg').fadeIn(700);
                    $('#sub_msg').hide().fadeOut(2000);
                    $("#sub_email").val(" ");
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }); 
</script>
<!-- Newsletter ajax code end-->

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
