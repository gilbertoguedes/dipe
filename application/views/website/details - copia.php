<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- ========== Product Details ======= -->
<section id="default" class="product_details">
    <div class="container">
        <div class="row product_details_inner">
            <div class="col-xl-5 col-md-6">
                <!--========== Product zoom Area ==========-->
                <div class="row m0 product_zoom">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="product1" role="tabpanel">
                            <div class="easyzoom easyzoom--adjacent">
                                <a href="<?php echo $image_large_details?>">
                                    <img src="<?php echo $image_thumb?>" alt="productImage">
                                </a>
                            </div>
                        </div>
                        <?php
                        if ($product_gallery_img) {
                            foreach ($product_gallery_img as $gallery) {
                        ?>
                        <div class="tab-pane" id="product_<?php echo $gallery->image_gallery_id?>" role="tabpanel">
                            <div class="easyzoom easyzoom--adjacent">
                                <a href="<?php echo $gallery->image_url?>">
                                    <img src="<?php echo $gallery->img_thumb?>" alt="productImage">
                                </a>
                            </div>
                        </div>
                       <?php
                            }
                        }
                       ?>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#product1" role="tab">
                                <img src="<?php echo $image_thumb?>" alt="" style="height:  80px;width:  80px;">
                            </a>
                            <input type="hidden" name="image" id="image" value="<?php echo $image_thumb?>">
                        </li>
                        <?php
                        if ($product_gallery_img) {
                            foreach ($product_gallery_img as $gallery_tab_img) {
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#product_<?php echo $gallery_tab_img->image_gallery_id?>" role="tab">
                                <img src="<?php echo $gallery_tab_img->img_thumb?>" alt="" style="height:  80px;width:  80px;">
                            </a>
                        </li>
                            <?php
                            }
                        }
                       ?>
                    </ul>
                </div>
                <!--======== End Product zoom Area ========-->
            </div>
            <div class="col-xl-7 col-md-6">
                <div class="row db m0 product_info">
                    <ol class="breadcrumb m0 p0">
                        <li class="breadcrumb-item"><a href="#"><?php echo display('home')?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('category_product/'.$category_id)?>"><?php echo $category_name?></a></li>
                        <li class="breadcrumb-item active"><?php echo $product_name?></li>
                    </ol>
                    <h2><?php echo $product_name?></h2>
                    <input type="hidden" name="name" id="name" value="<?php echo $product_name?>">
                    <div class="rating_area">
                        <div class="rate-container">
                        <?php
                            $result = $this->db->select('sum(rate) as rates')
                                                ->from('product_review')
                                                ->where('product_id',$product_id)
                                                ->get()
                                                ->row();

                            $rater = $this->db->select('rate')
                                                ->from('product_review')
                                                ->where('product_id',$product_id)
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
                    <?php if (!empty($product_details)) { ?>
                    <p class="about_product"><?php echo character_limiter(strip_tags($product_details), 200);?> </p>
                    <?php } ?>
                    <div class="product_type">
                        <?php if($type){ ?>
                        <p><?php echo display('product_type') ?> : <span><?php echo $type?></span></p>
                        <?php } ?>
                        <p><?php echo display('availability') ?> : <span>
                        <input type="hidden" value="<?php echo $stok?>" id="stok">

                        <?php
                        if ($stok > 0) {
                            echo display('in_stock');
                        }else{
                            echo display('out_of_stock');
                        }
                        ?></span></p>
                        <input type="hidden" name="model" id="model" value="<?php echo $product_model?>">
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

                    <?php
                    if ($onsale) {
                    ?>
                    <?php if($product_tax>0){ ?>
                        <div class="product_cost">
                            <span><?php echo "Precio del Producto sin Iva" ?> : </span>
                            <div class="current">
                                <p>
                                    <?php
                                    if ($target_con_rate > 1) {
                                        $price_iva = $onsale_price-((($onsale_price * $target_con_rate)*$product_tax)/100);
                                        echo (($position1==0)?$currency1." ".number_format($price_iva, 2, '.', ','):number_format($price_iva, 2, '.', ',')." ".$currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $price_iva = $onsale_price-((($onsale_price * $target_con_rate)*$product_tax)/100);
                                        echo (($position1==0)?$currency1." ".number_format($price_iva, 2, '.', ','):number_format($price_iva, 2, '.', ',')." ".$currency1);
                                    }
                                    ?>
                                </p>
                                    <input type="hidden" id="price_iva" name="price_iva" value="<?php echo $price_iva?>">
                            </div>
                        </div>
                        <div class="product_cost">
                            <span><?php echo "Iva" ?> : </span>
                            <div class="current">
                                <p>
                                    <?php
                                    echo $product_tax.' %';
                                    ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="product_cost">
                        <span><?php echo display('price_of_product') ?> : </span>
                        <div class="current">
                            <p>
                                <?php
                                    if ($target_con_rate > 1) {
                                        $onsale_price = $onsale_price * $target_con_rate;
                                        echo (($position1==0)?$currency1." ".number_format($onsale_price, 2, '.', ','):number_format($onsale_price, 2, '.', ',')." ".$currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $onsale_price = $onsale_price * $target_con_rate;
                                        echo (($position1==0)?$currency1." ".number_format($onsale_price, 2, '.', ','):number_format($onsale_price, 2, '.', ',')." ".$currency1);
                                    }
                                ?>
                            </p>

                            <input type="hidden" id="price" name="price" value="<?php echo $onsale_price?>">
                        </div>
                        <div class="previous">
                            <del>
                            <?php
                                if ($target_con_rate > 1) {
                                    $price = $price * $target_con_rate;
                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $price * $target_con_rate;
                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                }
                            ?>
                            </del>

                            <input type="hidden" id="discount" name="discount" value="<?php echo $price - $onsale_price?>">
                        </div>
                    </div>
                    <?php
                    }else{
                    ?>
                    <?php if($product_tax>0){ ?>
                    <div class="product_cost">
                        <span><?php echo "Precio del Producto sin Iva" ?> : </span>
                        <div class="current">
                            <p>
                            <?php
                            if ($target_con_rate > 1) {
                                $price_iva = $price-((($price * $target_con_rate)*$product_tax)/100);
                                echo (($position1==0)?$currency1." ".number_format($price_iva, 2, '.', ','):number_format($price_iva, 2, '.', ',')." ".$currency1);
                            }

                            if ($target_con_rate <= 1) {
                                $price_iva = $price-((($price * $target_con_rate)*$product_tax)/100);
                                echo (($position1==0)?$currency1." ".number_format($price_iva, 2, '.', ','):number_format($price_iva, 2, '.', ',')." ".$currency1);
                            }
                            ?>
                            </p>
                            <input type="hidden" id="price_iva" name="price_iva" value="<?php echo $price_iva?>">
                        </div>
                    </div>
                    <div class="product_cost">
                        <span><?php echo "Iva" ?> : </span>
                        <div class="current">
                            <p>
                                <?php
                                echo $product_tax.' %';
                                ?></p>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="product_cost">
                        <span><?php echo display('price_of_product') ?> : </span>
                        <div class="current">
                            <p>
                            <?php
                                if ($target_con_rate > 1) {
                                    $price = $price * $target_con_rate;
                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                }

                                if ($target_con_rate <= 1) {
                                    $price = $price * $target_con_rate;
                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                }
                            ?></p>
                            <input type="hidden" id="price" name="price" value="<?php echo $price?>">
                        </div>
                    </div>
                    <?php
                    }if ($variant) { ?>
                    <div class="product_size">
                        <span><?php echo display('product_size')?> * : </span>
                        <form action="#">
                            <select id="select_size1" required="">
                                <option value="0">Select</option>
                                <?php
                                if ($variant) {
                                    $exploded = explode(',', $variant);
                                    foreach ($exploded as $elem) {
                                    $this->db->select('*');
                                    $this->db->from('variant');
                                    $this->db->where('variant_id',$elem);
                                    $this->db->order_by('variant_name','asc');
                                    $result = $this->db->get()->row();
                                ?>
                                <option value="<?php echo $result->variant_id?>"><?php echo $result->variant_name?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                    <?php
                    }
                    ?>

                    <script type="text/javascript">
                        //Check variant stock
                        $('body').on('change', '#select_size1', function() {
                            var variant_id  = $(this).val();
                            var product_id  = '<?php echo $product_id;?>';

                            $.ajax({
                                type: "post",
                                async: true,
                                url: '<?php echo base_url('website/Product/check_variant_wise_stock')?>',
                                data: {variant_id:variant_id,product_id:product_id},
                                success: function(data) {
                                    if (data == '2') {
                                        alert('This variant is not available !');
                                        $(".product_size").load(location.href+" .product_size>*","");
                                        return false;
                                    }else{
                                        return true;
                                    }
                                },
                                error: function() {
                                    alert('Request Failed, Please check your code and try again!');
                                }
                            });
                        });
                    </script>

                    <div class="cart_counter">
                        <label><?php echo display('quantity') ?> : </label>
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;" class="reduced items-count" type="button">
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="<?php echo display('quantity') ?>" class="input-text qty" min="1">
                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button">
                            <i class="fa fa-angle-up"></i>
                        </button>
                    </div>
                    <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id?>">
                    <?php
                    if ($stok > 0) {
                    ?>
                    <a href="#" class="cart_btn" onclick="cart_btn(<?php echo $product_id?>)">
                        <i class="fa fa-shopping-cart"></i><?php echo display('add_to_cart')?>
                    </a>
                    <?php } ?>
                    <div class="product_share">
                        <span class="share-title"><?php echo display('share')?> : </span>
                        <ul class="social-icons">
                            <li>
                                <a class="share-button" data-share-url="<?php echo  current_url();?>" data-share-network="facebook" data-share-text="Share this awesome link on Facebook" data-share-title="Facebook Share" data-share-via="" data-share-tags="" data-share-media="" href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a class="share-button" data-share-url="<?php echo  current_url();?>" data-share-network="twitter" data-share-text="Share this awesome link on Twitter" data-share-title="Twitter Share" data-share-via="" data-share-tags="" data-share-media="" href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a class="share-button" data-share-url="<?php echo  current_url();?>" data-share-network="googleplus" data-share-text="Share this awesome link on Google+" data-share-title="Google+ Share" data-share-via="" data-share-tags="" data-share-media="" href="#"><i class="fa fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a class="share-button" data-share-url="<?php echo  current_url();?>" data-share-network="linkedin" data-share-text="Share this awesome link on LinkedIn" data-share-title="LinkedIn Share" data-share-via="" data-share-tags="" data-share-media="" href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a class="share-button" data-share-url="<?php echo  current_url();?>" data-share-network="pinterest" data-share-text="Share this awesome link on Pinterest" data-share-title="Pinterest Share" data-share-via="" data-share-tags="" data-share-media="" href="#"><i class="fa fa-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======= End Product Details =======-->

<!--========== Product Review Area ==========-->
<section class="product_review_area">
    <div class="container">
        <div class="row m0 db product_review">
            <!-- Nav tabs -->
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#reviews" role="tab"><?php echo display('review')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#description" role="tab"><?php echo display('description')?></a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tags" role="tab"><?php echo display('tag')?></a>
                </li>-->
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#specifications" role="tab"><?php echo display('specification')?></a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="reviews" role="tabpanel">
                    <div class="review_form row">
                        <?php if ($review) { ?>
                        <div class="col-md-6">
                            <div class="row m0 db need_review">
                                <?php if ($review) {
                                    echo $review;
                                } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-6">
                            <div class="review_message">
                                <h3><?php echo display('review_this_product')?></h3>
                                <div class="star_part">
                                    <span>
                                        <a class="star-1" href="javascript:void(0)" name="1">
                                            <i class="fa fa-star"></i>
                                        </a>
                                        <a class="star-2" href="javascript:void(0)" name="2">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </a>
                                        <a class="star-3 active" href="javascript:void(0)" name="3">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </a>
                                        <a class="star-4" href="javascript:void(0)" name="4">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </a>
                                        <a class="star-5" href="javascript:void(0)" name="5">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="row msg_part">
                                    <div class="col-md-12">
                                        <textarea class="form-control" placeholder="Your Message" id="review_msg"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="javascript:void(0)" class="review"><?php echo display('submit')?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="description" role="tabpanel">
                    <div class="row">
                        <?php if ($description) {
                            echo $description;
                        } ?>
                    </div>
                </div>
                <div class="tab-pane" id="tags" role="tabpanel">
                    <?php
                    if ($tag) {
                        $exploded = explode(',', $tag);
                        foreach ($exploded as $elem) {
                    ?>
                    <a href="#" class="nav"><?php echo $elem?></a>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="tab-pane" id="specifications" role="tabpanel">
                     <div class="row">
                        <?php if ($specification) {
                            echo $specification;
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========= End Product Review Area =========-->

<!-- Rating or review product -->
<script type="text/javascript">
    $(document).ready(function(){
        $('.star_part a').click(function(){
            $('.star_part a').removeClass("active");
            $(this).addClass("active");
        });


        //Add review
        $('body').on('click', '.review', function() {

            var product_id  = '<?php echo $product_id?>';
            var review_msg  = $('#review_msg').val();
            var customer_id = '<?php echo $this->session->userdata('customer_id')?>';
            var rate        = $('.star_part a.active').attr('name');

            /*alert('oka');*/

            /*//Review msg check
            if (review_msg == 0) {
                alert('Por favor, escriba un comentario !');
                return false;
            }

            //Customer id check
            if (customer_id == 0) {
                alert('<?php echo display('please_login_first')?>');
                return false;
            }

            $.ajax({
                type: "post",
                async: true,
                url: '<?php echo base_url('website/Home/add_review')?>',
                data: {product_id:product_id,customer_id:customer_id,review_msg:review_msg,rate:rate},
                success: function(data) {
                    if (data == '1') {
                        $('#review_msg').val('');
                        alert('Gracias por emitir su comentario !');
                        window.load();
                    }else if(data == '2'){
                        $('#review_msg').val('');
                        alert('Gracias, ya ha emitido un comentario antes !');
                        window.load();
                    }else if(data == '3'){
                        $('#review_msg').val('');
                        alert('<?php echo display('please_login_first')?>');
                        window.load();
                    }
                },
                error: function() {
                    alert('Request Failed, Please check your code and try again!');
                }
            });*/
        });
    });
</script>

<!--========== Electronics Product Area ==========-->
<section class="product_area wow fadeInUp">
    <div class="container">
        <div class="row db m0 product_inner">
            <div class="heading">
                <h2 class="bg_gray"><?php echo display('related_products')?></h2>
            </div>
            <div class="owl-carousel product_slider slider_style">
                <?php
                if ($related_product) {
                    foreach ($related_product as $product) {
                ?>
                <div class="item">
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
                                    <a href="<?php echo base_url('product_details/'.$product->product_id)?>" title="Product Details"><i class="fa fa-arrows"></i></a>
                                </li>
                            </ul>
                            <div class="addtocard">
                                <form action="" method="post">
                                    <input type="hidden" name="" id="product_id_<?php echo $product->product_id?>"  class="product_id" value="<?php echo $product->product_id?>">

                                    <?php if ($product->onsale == 1 && !empty($product->onsale_price)) { ?>
                                    <input type="hidden" name="price" id="price_<?php echo $product->product_id?>" value="<?php echo $product->onsale_price?>">
                                    <input type="hidden" name="discount" id="discount_<?php echo $product->product_id?>" value="<?php echo ($product->price-$product->onsale_price)?>">
                                    <?php }else{ ?>
                                    <input type="hidden" name="price" id="price_<?php echo $product->product_id?>" value="<?php echo $product->price?>">
                                    <?php } ?>

                                    <input type="hidden" name="qnty" id="qnty_<?php echo $product->product_id?>" value="1">
                                    <input type="hidden" name="image" id="image_<?php echo $product->product_id?>" value="<?php echo $product->image_thumb?>">
                                    <input type="hidden" name="name" id="name_<?php echo $product->product_id?>" value="<?php echo $product->product_name?>">
                                    <input type="hidden" name="model" id="model_<?php echo $product->product_id?>" value="<?php echo $product->product_model?>">
                                    <input type="hidden" name="supplier_price" id="supplier_price_<?php echo $product->product_id?>" value="<?php echo $product->supplier_price?>">

                                    <!-- Tax collection information start-->
                                    <?php
                                        $this->db->select('*');
                                        $this->db->from('tax_product_service');
                                        $this->db->where('product_id',$product->product_id);
                                        $this->db->where('tax_id','H5MQN4NXJBSDX4L');
                                        $tax_info = $this->db->get()->row();

                                        if (!empty($tax_info)) {
                                    ?>

                                    <?php if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                        $cgst = ($tax_info->tax_percentage * $product->onsale_price)/100;
                                     ?>
                                    <input type="hidden" name="cgst" id="cgst_<?php echo $product->product_id?>" value="<?php echo $cgst?>">
                                    <input type="hidden" name="cgst_id" id="cgst_id_<?php echo $product->product_id?>" value="<?php echo $tax_info->tax_id?>">
                                    <?php }else{
                                        $cgst = ($tax_info->tax_percentage * $product->price)/100;
                                    ?>
                                    <input type="hidden" name="cgst" id="cgst_<?php echo $product->product_id?>" value="<?php echo $cgst?>">
                                    <input type="hidden" name="cgst_id" id="cgst_id_<?php echo $product->product_id?>" value="<?php echo $tax_info->tax_id?>">
                                    <?php } ?>

                                    <?php } ?>

                                    <?php
                                        $this->db->select('*');
                                        $this->db->from('tax_product_service');
                                        $this->db->where('product_id',$product->product_id);
                                        $this->db->where('tax_id','52C2SKCKGQY6Q9J');
                                        $tax_info = $this->db->get()->row();

                                        if (!empty($tax_info)) {
                                    ?>

                                    <?php if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                        $sgst = ($tax_info->tax_percentage * $product->onsale_price)/100;
                                    ?>
                                    <input type="hidden" name="sgst" id="sgst_<?php echo $product->product_id?>" class="" value="<?php echo $sgst?>">
                                    <input type="hidden" name="sgst_id" id="sgst_id_<?php echo $product->product_id?>" value="<?php echo $tax_info->tax_id?>">
                                    <?php }else{
                                        $sgst = ($tax_info->tax_percentage * $product->price)/100;
                                    ?>
                                    <input type="hidden" name="sgst" id="sgst_<?php echo $product->product_id?>" class="" value="<?php echo $sgst?>">
                                    <input type="hidden" name="sgst_id" id="sgst_id_<?php echo $product->product_id?>" value="<?php echo $tax_info->tax_id?>">
                                    <?php } ?>

                                    <?php } ?>

                                    <?php
                                        $this->db->select('*');
                                        $this->db->from('tax_product_service');
                                        $this->db->where('product_id',$product->product_id);
                                        $this->db->where('tax_id','5SN9PRWPN131T4V');
                                        $tax_info = $this->db->get()->row();

                                        if (!empty($tax_info)) {
                                    ?>

                                    <?php if ($product->onsale == 1 && !empty($product->onsale_price)) {
                                        $igst = ($tax_info->tax_percentage * $product->onsale_price)/100;
                                     ?>
                                    <input type="hidden" name="igst" id="igst_<?php echo $product->product_id?>" class="" value="<?php echo $igst?>">
                                    <input type="hidden" name="igst_id" id="igst_id_<?php echo $product->product_id?>" value="<?php echo $tax_info->tax_id?>">
                                    <?php }else{
                                        $igst = ($tax_info->tax_percentage * $product->price)/100;
                                    ?>
                                    <input type="hidden" name="igst" id="igst_<?php echo $product->product_id?>" class="" value="<?php echo $igst?>">
                                    <input type="hidden" name="igst_id" id="igst_id_<?php echo $product->product_id?>" value="<?php echo $tax_info->tax_id?>">
                                    <?php } ?>

                                    <?php } ?>
                                    <!-- Tax collection information end-->
                                    <a href="<?php echo base_url('product_details/'.$product->product_id)?>">
                                        <button type="button" class="cart_button"><?php echo display('add_to_cart')?></button>
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
        </div>
    </div>
</section>
<!-- ========== End Electronics Product Area ========== -->

<script type="text/javascript">

    $( document ).ready(function() {
        var stok = $('#stok').val();
        if (stok == "none") {
            alert('<?php echo display('please_set_default_store')?>');
        }
    });

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
                    alert('<?php echo display('please_login_first')?>');
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    });
</script>