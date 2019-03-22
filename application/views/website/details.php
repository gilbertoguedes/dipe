<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- ========================= SECTION PRODUCTOVIEW ========================= -->
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
<section class="section-content bg padding-y-sm dipe-section-content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <nav class="col-md-18-24">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo display('home')?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('category/'.$category_id)?>"><?php echo $category_name?></a></li>
                            <li class="breadcrumb-item active depi-capitalice-text"><?php echo $product_name?></li>
                        </ol>
                    </nav> <!-- col.// -->
                    <a class="btn ml-2 dipe-btn-warning btn-warning" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Seguir comprando</a>
        
                </div> <!-- row.// -->


            </div> <!-- card-body .// -->
        </div> <!-- card.// -->

        <div class="padding-y-sm">
            <!--<span>3897 results for "Item"</span>-->
        </div>




        <div class="card">
            <div class="row no-gutters">
                <aside class="col-sm-5 border-right">
                    <article class="gallery-wrap">
                        <div class="easyzoom dipe-easyzoom--overlay easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="<?php echo $image_large_details?>">
                                <img src="<?php echo $image_thumb?>">
                            </a>
                        </div>
                        <ul class="img-small-wrap dipe-thumbnails thumbnails">
                            <li class="dipe-item-gallery item-gallery"> <a href="<?php echo $image_large_details?>" data-standard="<?php echo $image_large_details?>"> <img src="<?php echo $image_thumb?>"></li> </a>
                            <?php if ($product_gallery_img) {
                            foreach ($product_gallery_img as $gallery) {
                            ?>
                                <li class="dipe-item-gallery item-gallery">
                                    <a href="<?php echo $gallery->image_url?>" data-standard="<?php echo $gallery->image_url?>">
                                        <img src="<?php echo $gallery->img_thumb?>" alt="productImage">
                                    </a>
                                </li>
                            <?php
                            }
                            }
                            ?>
                            <!--<div class="item-gallery"> <img src="images/items/2.jpg"></div>
                            <div class="item-gallery"> <img src="images/items/3.jpg"></div>
                            <div class="item-gallery"> <img src="images/items/4.jpg"></div>-->
                        </ul> <!-- slider-nav.// -->
                    </article> <!-- gallery-wrap .end// -->
                </aside>
                <aside class="col-sm-7">
                    <article class="p-5">
                        <h3 class="title mb-3 dipe-color-6"><?php echo $product_name?></h3>
                        <h6 class="title mb-3 dipe-color-6">Clave: <?php echo $product_id;?></h6>

                        <div class="rating-wrap p-3 dipe-gray-1-bg ">
                            <?php
                            $total_rate = 0;
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
                            <span class="dipe-h6 dipe-remove-vertical-align dipe-gray-text-2-bg" > / Calificación del producto</span>
                        </div> <!-- rating-wrap.// -->

                        <dl>
                            <!--<dt>Descripción</dt>-->
                            <dd><p class="dipe-gray-text-3-bg pt-3"><?php echo $product_details?></p></dd>
                        </dl>
                        <hr>
                        <dl class="row">
                            <dt class="col-sm-6 col-md-3 col-lg-3 col-xl-3">Precio final</dt>
                            <dd class="col-sm-6 col-md-9 col-lg-9 col-xl-9">

                                <?php
                                if($onsale == "1")
                                {
                                    if ($target_con_rate > 1) {
                                        $price = $onsale_price * $target_con_rate;
                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $price = $onsale_price * $target_con_rate;
                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }
                                }
                                else
                                {
                                    if ($target_con_rate > 1) {
                                        $price = $price * $target_con_rate;
                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }

                                    if ($target_con_rate <= 1) {
                                        $price = $price * $target_con_rate;
                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                    }
                                }

                                ?>
                            </dd>
                            <input type="hidden" value="<?php echo $stok?>" id="stok">
                            <dt class="col-sm-6 col-md-3 col-lg-3 col-xl-3">Disponibilidad</dt>
                            <dd class="col-sm-6 col-md-9 col-lg-9 col-xl-9"><?php echo $stok;?> </dd>

                        </dl>

                        <hr>
                        <div class="row">
                            <div class="col-sm-5">
                                <dl class="dlist-inline">
                                    <dt>Cantidad: </dt>
                                    <dd>
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;" class="reduced items-count" type="button">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <input type="text" name="qty" id="sst" maxlength="12" value="1" title="<?php echo display('quantity') ?>" class="input-text qty" min="1">
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button">
                                            <i class="fa fa-angle-up"></i>
                                        </button>
                                        <!--aki va el componente ke esta en el ecomerce viejo-->
                                    </dd>
                                    <?php if ($variant) { ?>
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
                                </dl>  <!-- item-property .// -->
                            </div> <!-- col.// -->
                            <div class="col-sm-7">
                                <!--<dl class="dlist-inline">-->
                                <!--<dt>Size: </dt>-->
                                <!--<dd>-->
                                <!--<label class="form-check form-check-inline">-->
                                <!--<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">-->
                                <!--<span class="form-check-label">SM</span>-->
                                <!--</label>-->
                                <!--<label class="form-check form-check-inline">-->
                                <!--<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">-->
                                <!--<span class="form-check-label">MD</span>-->
                                <!--</label>-->
                                <!--<label class="form-check form-check-inline">-->
                                <!--<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">-->
                                <!--<span class="form-check-label">XXL</span>-->
                                <!--</label>-->
                                <!--</dd>-->
                                <!--</dl>  &lt;!&ndash; item-property .// &ndash;&gt;-->
                            </div> <!-- col.// -->
                        </div> <!-- row.// -->
                        <hr>
                        <?php
                        if ($stok > 0) {
                            ?>
                            <a href="#" class="btn  btn-warning dipe-btn-warning" onclick="cart_btn('<?php echo $product_id?>')"> <i class="fas fa-shopping-cart"></i>
                                Añadir al carrito </a>
                        <?php
                        }
                        ?>
                    </article> <!-- card-body.// -->
                </aside> <!-- col.// -->
            </div> <!-- row.// -->
        </div> <!-- card.// -->



    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION PRODUCTOVIEW END// ========================= -->


<!-- ========================= SECTION CALIFICAR P ========================= -->
<section class="section-content padding-y dipe-bg-g pt-5 section-calificar-p">
    <div class="container">
        <!-- Tabs with icons on Card -->
        <div class="depi-tapcalificar-card card card-nav-tabs">
            <div class="card-header card-header-primary">
                <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#profile" data-toggle="tab">
                                    Especificaciones
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#messages" data-toggle="tab">
                                    <!--<i class="material-icons">chat</i>-->
                                    Datos
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><div class="card-body ">
                <div class="tab-content text-center">
                    <div class="tab-pane active" id="profile">
                        <div class="row p-lg-5 p-md-3 p-xs-1 p-sm-2 ">
                            <div class="dipe-footer-left-col col-sm-6 col-lg-6 text-left dipe-grayblue-text-1-bg pt-2 ">
                                <p class="dipe-textsize-9">
                                    <?php if ($specification) {
                                        echo $specification;
                                    } ?>
                                </p>
                            </div>
                            <div class="dipe-footer-right-col col-sm-6 col-lg-6 text-left dipe-grayblue-text-1-bg pt-2">
                                <h6 class="h4 dipe-gray-text-3-bg">Califica este producto</h6>
                                <!--aki poner las estrellitas para calificar el producto-->
                                <div class="p-3 dipe-gray-2-bg ">
                                    <div class="dipe-star_part star_part">
                                        <span>
                                            <a class="star-1 px-3" href="javascript:void(0)" name="1">
                                                <i class="fa fa-star"></i>
                                            </a>
                                            <a class="star-2 px-3" href="javascript:void(0)" name="2">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </a>
                                            <a class="star-3 px-3 active" href="javascript:void(0)" name="3">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </a>
                                            <a class="star-4 px-3" href="javascript:void(0)" name="4">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </a>
                                            <a class="star-5 px-3" href="javascript:void(0)" name="5">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </a>
                                        </span>
                                    </div>

                                </div>


                                <div class="form-group mt-3">
                                    <label for="exampleFormControlTextarea1">Escriba su valoración</label>
                                    <textarea class="form-control" id="review_msg" rows="5"></textarea>
                                </div>
                                <a href="#" class="btn  btn-warning dipe-btn-warning review"> Enviar </a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages">
                        <?php if ($review) {
                            echo $review;
                        } ?>
                    </div>
                </div>
            </div></div>
        <!-- End Tabs with icons on Card -->



    </div>
</section>


<!--SECTION RELACIONADOS, PUEDE INTERESAR-->
<section class="section-content padding-y dipe-bg-g section-ofertas pt-1">
    <div class="container">

        <header class="section-heading">
            <h3 class="dipe-title-section title-section"><i class="fa fa-angle-right"></i> Le puede interesar</h3>
        </header>

        <div class="card">
            <div class="row ">

                <div class="col-md-12 px-5">

                    <!-- ============== owl slide items  ============= -->
                    <div class="dipe-detailpage-owl-carousel owl-carousel owl-init slide-items" data-items="5" data-margin="20" data-dots="false" data-nav="true">
                        <?php if($related_product){ ?>

                        <?php foreach($related_product as $prod){ ?>
                        <div class="item-slide dipe-min-with-150">
                            <a href="<?php echo base_url('product_details/'.$prod->product_id)?>">
                            <figure class="card card-product border-0 dipe-nomargin pt-md-2 pt-xl-4">
                                <div class="img-fluid">
                                    <img src="<?php echo $prod->image_thumb?>">
                                    <div class = "dipe-slide-item-overlay btn-overlay">
                                        <a class="dipe-slide-item-overlay-btn" href="<?php echo base_url('product_details/'.$prod->product_id) ?>"><i class="fa fa-search-plus"></i> </a>
                                        <a class="dipe-slide-item-overlay-btn" href="#" onclick="cart_btn_one('<?php echo $prod->product_id; ?>')"><i class="fa fa-cart-plus"></i> </a>
                                    </div>
                                </div>
                                <figcaption class="info-wrap border-0 dipe-oferta-info-wrap p-1">
                                    <a href="#" class="title"><?php echo $prod->product_name;?></a>
                                    <div class="action-wrap">
                                        <!--<a href="#" class="btn btn-primary btn-sm float-right"> Order </a>-->
                                        <div class="price-wrap h5 dipe-nomargin">
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
                                            <?php if($prod->onsale=="1"){ ?>
                                                <span class="price-new">
                                                <?php
                                                if ($target_con_rate > 1) {
                                                    $price =$prod->onsale_price * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }

                                                if ($target_con_rate <= 1) {
                                                    $price = $prod->onsale_price * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }
                                                ?>
                                                </span>

                                                <del class="price-old">
                                                    <?php
                                                    if ($target_con_rate > 1) {
                                                        $price = $prod->price * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }

                                                    if ($target_con_rate <= 1) {
                                                        $price = $prod->price * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }
                                                    ?>
                                                </del>
                                            <?php }else{ ?>
                                                <span class="price-new">
                                                <?php
                                                if ($target_con_rate > 1) {
                                                    $price = $prod->price * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }

                                                if ($target_con_rate <= 1) {
                                                    $price = $prod->price * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }
                                                ?>
                                                </span>
                                            <?php } ?>
                                        </div> <!-- price-wrap.// -->
                                    </div> <!-- action-wrap -->
                                </figcaption>
                            </figure> <!-- card // -->
                            </a>
                        </div>
                        <?php } ?>
                        <?php } ?>

                    </div>
                    <!-- ============== owl slide items .end // ============= -->

                </div> <!-- col.// -->
            </div> <!-- row.// -->

        </div> <!-- card.// -->


    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION le puede interesar END// ========================= -->