<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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

if ($currency_new_id) {
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
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y-sm dipe-section-content">
<div class="container">
<div class="card">
    <div class="card-body">
        <div class="row">

            <nav class="col-md-18-24">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo display('home')?></a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo $category_name; ?></a></li>
                    <!--<li class="breadcrumb-item"><a href="#"><?php echo display('category')?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Items</li>-->
                </ol>
            </nav> <!-- col.// -->

        </div> <!-- row.// -->


    </div> <!-- card-body .// -->
</div> <!-- card.// -->

<div class="padding-y-sm">
    <!--<span>3897 results for "Item"</span>-->
</div>

<div class="row-sm">
<?php if ($category_product) { ?>
<?php foreach ($category_product as $product) {
?>
<div class="col-md-4 col-sm-6 col-lg-3">
    <a href="<?php echo base_url('product_details/'.$product->product_id);?>">
    <figure class="card card-product dipe-min-height-300 ">
        <div class="img-wrap dipe-heigt-170px">
            <img src="<?php echo $product->image_thumb?>" alt="product-image">
        </div>
        <div class="dipe-slide-item-overlay btn-overlay">
            <a class="dipe-slide-item-overlay-btn" href="<?php echo base_url('product_details/'.$product->product_id)?>"><i class="fa fa-search-plus"></i> </a>
            <a class="dipe-slide-item-overlay-btn" href="#" onclick="cart_btn_one('<?php echo $product->product_id ?>')"><i class="fa fa-cart-plus"></i> </a>
        </div>
        <figcaption class="info-wrap normalize-product-text pt-0 pt-lg-3 pt-xl-3 ">
            <p class="desc nomargin dipe-crop-text-1"> <?php echo $product->product_name; ?></p>
            <div class="rating-wrap">
                <?php
                $total_rate = 0;
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
                }
                ?>
                <ul class="rating-stars dipe-remove-vertical-align">
                    <?php if($total_rate==0){?>
                        <li style="width:0%" class="stars-active">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        </li>
                    <?php } ?>
                    <?php if($total_rate>=1 && $total_rate<2){?>
                        <li style="width:20%" class="stars-active">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        </li>
                    <?php } ?>
                    <?php if($total_rate>=2 && $total_rate<3){?>
                        <li style="width:40%" class="stars-active">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        </li>
                    <?php } ?>
                    <?php if($total_rate>=3 && $total_rate<4){?>
                        <li style="width:60%" class="stars-active">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        </li>
                    <?php } ?>
                    <?php if($total_rate>=4 && $total_rate<5){?>
                        <li style="width:80%" class="stars-active">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        </li>
                    <?php } ?>
                    <?php if($total_rate>=5 && $total_rate<6){?>
                        <li style="width:100%" class="stars-active">
                            <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        </li>
                    <?php } ?>
                    <li>
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </li>
                </ul>
            </div> <!-- rating-wrap.// -->
        </figcaption>
        <div class="bottom-wrap text-center font-weight-bold dipe-noborder pt-0">
            <div class="price-wrap ">
                <?php if($product->onsale==1){ ?>
                    <span class="price-new">
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
                    </span>
                    <del class="price-old">
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
                    </del>
                <?php }else{ ?>
                    <span class="price-new">
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
                        </span>
                <?php } ?>
            </div> <!-- price-wrap.// -->
        </div> <!-- bottom-wrap.// -->
    </figure>
    </a>
</div>
<?php } ?>
<?php } ?>
</div> <!-- row.// -->
<nav aria-label="page navigation example">
    <?php echo $links?>
</nav>

</div><!-- container // -->
</section>
<!-- ========================= SECTION CONTENT .END// ========================= -->
