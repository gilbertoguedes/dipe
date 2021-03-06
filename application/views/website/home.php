<?php defined('BASEPATH') OR exit('No direct script access allowed');  $this->session->set_userdata('message',''); ?>

<section class="section-main dipe-bg bg padding-top-sm pb-4">
    <div class="container-fluid">

        <div class="row row-sm dipe-home-top-section">
            <aside class="col-md-3 col-lg-2 d-none d-lg-block d-xl-block pl-3">
                <div class="card dipe-noborder">
                    <header class="dipe-card-header card-header bg-white dipe-gray-text-4-bg pl-0">
                        MIS PRODUCTOS
                    </header>
                    <ul class="menu-category dipe-menu-category">
                        <?php
                        /*var_dump($category_list);*/
                        if ($category_list) {
                            foreach ($category_list as $parent_category) {
                                $sub_parent_cat =  $this->db->select('*')
                                    ->from('product_category')
                                    ->where('parent_category_id',$parent_category->category_id)
                                    ->order_by('menu_pos')
                                    ->get()
                                    ->result();
                                ?>
                                <li class="px-1">
                                    <a href="#" class="px-0 ">
                                        <i class="fas fa-circle dipe-font-size-6 align-middle d-xl-none"></i> <span class="align-content-start"> <?php echo ucwords(mb_strtolower($parent_category->category_name,"UTF-8"))?></span> <?php if($sub_parent_cat){ ?><i class="fa fa-angle-right pt-1 float-right dipe-gray-text-2-bg d-lg-none d-xl-block"></i><?php } ?></a>
                                    <?php
                                    if ($sub_parent_cat){
                                        ?>
                                        <div class="shadow submenu">
                                            <div class="row">
                                            <?php
                                            if ($sub_parent_cat) {
                                                foreach ($sub_parent_cat as $parent_cat) {
                                                    ?>
                                                    <div class="submenu-item col-lg-7-24">
                                                        <ul>
                                                            <li class="dipe-submenu-category-title"><?php echo $parent_cat->category_name?></li>
                                                            <?php
                                                            $sub_cat =  $this->db->select('*')
                                                                ->from('product_category')
                                                                ->where('parent_category_id',$parent_cat->category_id)
                                                                ->where('parent_category_nivel2',$parent_category->category_id)
                                                                ->order_by('menu_pos')
                                                                ->get()
                                                                ->result();
                                                            if ($sub_cat) {
                                                                foreach ($sub_cat as $s_p_cat) {
                                                                    ?>
                                                                    <li class="dipe-submenu-final-item"><a href="<?php echo base_url('category/'.$s_p_cat->category_id)?>"><?php echo ucwords(mb_strtolower($s_p_cat->category_name,"UTF-8"))?></a></li>
                                                                <?php
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                <?php
                                                }
                                            }
                                            ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div> <!-- card.// -->
            </aside> <!-- col.// -->
            <div class="col-md-7 col-lg-8 p-0">
                <div class="card dipe-noborder">
                    <div class="card-body px-1 pt-3">
                        <!-- ================= main slide ================= -->
<!--                        <div class="owl-init slider-main owl-carousel" data-items="1" data-nav="true" data-dots="false">-->


                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <?php
                                if ($slider_list) {
                                    ?>
                                    <div class="carousel-item active">
                                        <a href="<?php echo $slider_list[0]['slider_link']?>" target="_blank">
                                            <img src="<?php echo $slider_list[0]['slider_image']?>"  alt="sliderImage">
                                        </a>
                                    </div>
                                    <?php
                                    foreach ($slider_list as $slider) {
                                        ?>
                                        <div class="carousel-item ">
                                            <a href="<?php echo $slider['slider_link']?>" target="_blank">
                                                <img src="<?php echo $slider['slider_image']?>"  alt="sliderImage">
                                            </a>
                                        </div>
                                        <!--<div class="item-slide dipe-item-slide">
                                            <img src="http://localhost/my-assets/image/banner3.jpg">
                                        </div>
                                        <div class="item-slide dipe-item-slide">
                                            <img src="http://localhost/my-assets/image/banner2.jpg">
                                        </div>
                                        <div class="item-slide dipe-item-slide">
                                            <img src="http://localhost/my-assets/image/banner1.jpg">
                                        </div>-->
                                        <?php
                                    }
                                }
                                ?>


                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>











                        <!-- ============== main slidesow .end // ============= -->
                    </div> <!-- card-body .// -->
                </div> <!-- card.// -->
            </div> <!-- col.// -->

            <aside class="col-md-5 col-lg-2 pt-3 hover11">

                <h6 class="title-bg dipe-gray-text-4-bg dipe-yellow-bg"> Productos en Oferta</h6>
                <div >
                    <?php if($products_ofert){  ?>
                        <?php for ($i=0; $i < /*count($products_ofert)*/3; $i++) { ?>
                            <a href="<?php echo base_url('product_details/'.$products_ofert[$i]['product_id'])?>">
                            <figure class="itemside has-bg border-bottom " >
                                <img class="img-bg" src="<?php echo $products_ofert[$i]['image_thumb']?>" height="80">
                                <figcaption class="p-2 w-75">
                                    <h6 class="title dipe-gray-text-4-bg dipe-textsize-9"><?php echo ucwords(mb_strtolower($products_ofert[$i]['product_name'],"UTF-8"))?> </h6>
                                    <div class="price-wrap">
                                        <span class="price-new">
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
                                                <?php if ($products_ofert[$i]['onsale'] == 1 && !empty($products_ofert[$i]['onsale_price'])) { ?>
                                                    <span class="price-new">
                                                    <?php
                                                    if ($target_con_rate > 1) {
                                                        $price = $products_ofert[$i]['onsale_price'] * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }

                                                    if ($target_con_rate <= 1) {
                                                        $price = $products_ofert[$i]['onsale_price'] * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }
                                                    ?>
                                                    </span>
                                                    <del class="price-old">
                                                    <?php
                                                    if ($target_con_rate > 1) {
                                                        $price = $products_ofert[$i]['price'] * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }

                                                    if ($target_con_rate <= 1) {
                                                        $price = $products_ofert[$i]['price'] * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }
                                                    ?>
                                                    </del>
                                                <?php }else{ ?>
                                                    <span class="price-new">
                                                    <?php
                                                    if ($target_con_rate > 1) {
                                                        $price = $products_ofert[$i]['price'] * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }

                                                    if ($target_con_rate <= 1) {
                                                        $price = $products_ofert[$i]['price'] * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }
                                                    ?>
                                                    </span>
                                                <?php } ?>
                                        </span>
                                    </div>
                                    <h6 class="dipe-yellow-text pt-1">
                                        <?php
                                        $result = $this->db->select('sum(rate) as rates')
                                            ->from('product_review')
                                            ->where('product_id',$products_ofert[$i]['product_id'])
                                            ->get()
                                            ->row();

                                        $rater = $this->db->select('rate')
                                            ->from('product_review')
                                            ->where('product_id',$products_ofert[$i]['product_id'])
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
                                    </h6>
                                </figcaption>
                            </figure>
                            </a>

                        <?php } ?>
                    <?php } ?>
                </div>

            </aside>


        </div>
    </div> <!-- container .//  -->
</section>
<!-- ========================= SECTION MAIN END// ========================= -->

<!-- ========================= SECTION POPULAR ========================= -->
<?php if($popular_category){ ?>
<section class="section-content padding-y dipe-bg-g pt-5 section-popular">
    <div class="container">

        <header class="section-heading">
            <h3 class="dipe-title-section title-section"><i class="fa fa-angle-right"></i> Lo más popular</h3>
        </header>


        <div class = "card dipe-pl-19 pt-3 pb-3 pr-4 dipe-carousel-populares">
        <div class="owl-carousel owl-init slide-items" data-items="5" data-margin="5" data-dots="false" data-nav="true">
            <?php for ($i=0; $i < count($popular_category); $i++) { ?>
                <div class="item-slide dipe-min-with-150 hover01">
                    <figure class="itemside ">
                        <div class="aside"><div class="img-wrap img-sm">
                                <a href="<?php echo base_url('category/'.$popular_category[$i]['category_id'])?>" class="dipe-gray-text-3-bg  ">
                                <img src="<?php echo $popular_category[$i]['cat_image']?>">
                                    </a>
                            </div>
                        </div>
                        <figcaption class="p-2 align-self-center dipe-popular-caption">
                            <a href="<?php echo base_url('category/'.$popular_category[$i]['category_id'])?>" class="dipe-gray-text-3-bg  ">
                                <h6 class="title"><?php echo $popular_category[$i]['category_name']?></h6>
                                </a>
                            <!--<a href="#">More details</a>-->
                        </figcaption>
                    </figure>

                </div>
            <?php } ?>
        </div>
        </div>

    </div> <!-- container .//  -->
</section>
<?php } ?>
<!-- ========================= SECTION POPULAR END// ========================= -->

<?php if($products_new){ ?>
<!-- ========================= SECTION OFERTAS ========================= -->
<section class="section-content padding-y dipe-bg-g section-ofertas pt-1">

    <div class="container">

        <header class="section-heading">
            <h3 class="dipe-title-section title-section"><i class="fa fa-angle-right"></i> Nuevos Productos</h3>
        </header>

        <div class="card">
            <div class="row ">


                <div class="col-md-3 pr-0">

                    <div class="hover15 column d-none d-md-block">
                        <div>
                        <a href="/product_new">
                        <figure>
                            <img src="<?php echo base_url('assets/website/maqueta/images/nuevos.jpg')?>" class="img-fluid " alt="Ofertas">
                        </figure>
                        </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 px-5">

                    <!-- ============== owl slide items  ============= -->
                    <div class="owl-carousel owl-init slide-items" data-items="5" data-margin="5" data-dots="false" data-nav="true">
                        <?php for ($i=0; $i < count($products_new); $i++) { ?>
                        <div class="item-slide dipe-min-with-150 hover01">
                            <a href="<?php echo base_url('product_details/'.$products_new[$i]['product_id'])?>">
                            <figure class="card card-product border-0 dipe-nomargin pt-md-2 pt-xl-4">
                                <div class="img-fluid">
                                    <img src="<?php echo $products_new[$i]['image_thumb']?>">
                                    <div class = "dipe-slide-item-overlay btn-overlay">
                                        <a class="dipe-slide-item-overlay-btn" href="<?php echo base_url('product_details/'.$products_new[$i]['product_id'])?>"><i class="fa fa-search-plus"></i> </a>
                                        <a class="dipe-slide-item-overlay-btn" href="#" onclick="cart_btn_one('<?php echo $products_new[$i]['product_id']; ?>')"><i class="fa fa-cart-plus"></i> </a>
                                    </div>
                                </div>
                                <figcaption class="info-wrap border-0 dipe-oferta-info-wrap p-1">
                                    <a href="#" class="title"><?php echo $products_new[$i]['product_name']?></a>
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
                                            <?php if($products_new[$i]['onsale']=="1"){ ?>
                                                <span class="price-new">
                                                <?php
                                                if ($target_con_rate > 1) {
                                                    $price = $products_new[$i]['onsale_price'] * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }

                                                if ($target_con_rate <= 1) {
                                                    $price = $products_new[$i]['onsale_price'] * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }
                                                ?>
                                                </span>

                                                <del class="price-old">
                                                    <?php
                                                    if ($target_con_rate > 1) {
                                                        $price = $products_new[$i]['price'] * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }

                                                    if ($target_con_rate <= 1) {
                                                        $price = $products_new[$i]['price'] * $target_con_rate;
                                                        echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                    }
                                                    ?>
                                                </del>
                                            <?php }else{ ?>
                                                <span class="price-new">
                                                <?php
                                                if ($target_con_rate > 1) {
                                                    $price = $products_new[$i]['price'] * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }

                                                if ($target_con_rate <= 1) {
                                                    $price = $products_new[$i]['price'] * $target_con_rate;
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
                    </div>

                    <!-- ============== owl slide items .end // ============= -->

                </div> <!-- col.// -->
            </div> <!-- row.// -->

        </div> <!-- card.// -->
        <figure class="mt-5 banner bg-secondary">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/1.jpg')?>" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/2.jpg')?>" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/1.jpg')?>" alt="Third slide">
                    </div>
                </div>
            </div>
        </figure>

    </div> <!-- container .//  -->

</section>
<?php } ?>
<!-- ========================= SECTION OFERTAS END// ========================= -->

<?php if($products_ofert){ ?>
    <!-- ========================= SECTION OFERTAS ========================= -->
    <section class="section-content dipe-bg-g section-ofertas pt-1">

        <div class="container">

            <header class="section-heading">
                <h3 class="dipe-title-section title-section"><i class="fa fa-angle-right"></i> Productos en oferta</h3>
            </header>

            <div class="card">
                <div class="row ">


                    <div class="col-md-3 pr-0">

                        <div class="hover15 column d-none d-md-block">
                            <div class="">
                                <a href="/product_oferts">
                                <figure>
                                    <img src="<?php echo base_url('assets/website/maqueta/images/home-ofertas.jpg')?>" class="img-fluid " alt="Ofertas">
                                </figure>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 px-5">

                        <!-- ============== owl slide items  ============= -->
                        <div class="owl-carousel owl-init slide-items" data-items="5" data-margin="5" data-dots="false" data-nav="true">
                            <?php for ($i=0; $i < count($products_ofert); $i++) { ?>
                                <div class="item-slide dipe-min-with-150 hover01">
                                    <a href="<?php echo base_url('product_details/'.$products_ofert[$i]['product_id'])?>">
                                        <figure class="card card-product border-0 dipe-nomargin pt-md-2 pt-xl-4">
                                            <div class="img-fluid">
                                                <img src="<?php echo $products_ofert[$i]['image_thumb']?>">
                                                <div class = "dipe-slide-item-overlay btn-overlay">
                                                    <a class="dipe-slide-item-overlay-btn" href="<?php echo base_url('product_details/'.$products_ofert[$i]['product_id'])?>"><i class="fa fa-search-plus"></i> </a>
                                                    <a class="dipe-slide-item-overlay-btn" href="#" onclick="cart_btn_one('<?php echo $products_ofert[$i]['product_id']; ?>')"><i class="fa fa-cart-plus"></i> </a>
                                                </div>
                                            </div>
                                            <figcaption class="info-wrap border-0 dipe-oferta-info-wrap p-1">
                                                <a href="#" class="title"><?php echo $products_ofert[$i]['product_name']?></a>
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
                                                        <span class="price-new">
                                                <?php
                                                if ($target_con_rate > 1) {
                                                    $price = $products_ofert[$i]['onsale_price'] * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }

                                                if ($target_con_rate <= 1) {
                                                    $price = $products_ofert[$i]['onsale_price'] * $target_con_rate;
                                                    echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                }
                                                ?>
                                                </span>

                                                        <del class="price-old">
                                                            <?php
                                                            if ($target_con_rate > 1) {
                                                                $price = $products_ofert[$i]['price'] * $target_con_rate;
                                                                echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                            }

                                                            if ($target_con_rate <= 1) {
                                                                $price = $products_ofert[$i]['price'] * $target_con_rate;
                                                                echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                                            }
                                                            ?>
                                                        </del>
                                                    </div> <!-- price-wrap.// -->
                                                </div> <!-- action-wrap -->
                                            </figcaption>
                                        </figure> <!-- card // -->
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- ============== owl slide items .end // ============= -->

                    </div> <!-- col.// -->
                </div> <!-- row.// -->

            </div> <!-- card.// -->
            <figure class="mt-5 banner bg-secondary">
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/1.jpg')?>" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/2.jpg')?>" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/1.jpg')?>" alt="Third slide">
                        </div>
                    </div>
                </div>
            </figure>


        </div> <!-- container .//  -->
    </section>
<?php } ?>
<!-- ========================= SECTION OFERTAS END// ========================= -->

<!-- ========================= SECTION RECOMENDACIONES ========================= -->
<?php if($products_recomend){ ?>
<section class="section-content padding-y dipe-bg-g section-recomendaciones pt-1">
<div class="container">

<header class="section-heading">
    <h3 class="dipe-title-section title-section"><i class="fa fa-angle-right"></i> Recomendaciones</h3>
</header>
<div class="dipe-card card p-md-1">
<div class="row">
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
    <?php for ($i=0; $i < count($products_recomend); $i++) { ?>
    <div class="col-md-4 col-sm-6 col-lg-2 pt-1 hover01">
        <a href="<?php echo base_url('product_details/'.$products_recomend[$i]['product_id'])?>">
        <figure class="card card-product border-0 dipe-nomargin">
            <div class="img-wrap"><img src="<?php echo $products_recomend[$i]['image_thumb']?>"></div>
            <div class = "dipe-slide-item-overlay btn-overlay">
                <a class="dipe-slide-item-overlay-btn" href="<?php echo base_url('product_details/'.$products_recomend[$i]['product_id'])?>"><i class="fa fa-search-plus"></i> </a>
                <a class="dipe-slide-item-overlay-btn" href="#" onclick="cart_btn_one('<?php echo $products_recomend[$i]['product_id']; ?>')"><i class="fa fa-cart-plus"></i> </a>
            </div>
            <figcaption class="info-wrap normalize-product-text pt-0 pt-lg-3 pt-xl-3 ">
                <p class="desc nomargin"><?php echo $products_recomend[$i]['product_name']?></p>
                <div class="rating-wrap">
                    <ul class="rating-stars">
                        <?php
                        $total_rate = 0;
                        $result = $this->db->select('sum(rate) as rates')
                            ->from('product_review')
                            ->where('product_id',$products_recomend[$i]['product_id'])
                            ->get()
                            ->row();

                        $rater = $this->db->select('rate')
                            ->from('product_review')
                            ->where('product_id',$products_recomend[$i]['product_id'])
                            ->get()
                            ->num_rows();

                        if ($result->rates != null) {
                            $total_rate = $result->rates/$rater;
                        }
                        ?>
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
                    <?php if($products_recomend[$i]['onsale']==1){ ?>
                        <span class="price-new">
                            <?php
                            if ($target_con_rate > 1) {
                                $price = $products_recomend[$i]['onsale_price'] * $target_con_rate;
                                echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                            }

                            if ($target_con_rate <= 1) {
                                $price = $products_recomend[$i]['onsale_price'] * $target_con_rate;
                                echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                            }
                            ?>
                        </span>
                        <del class="price-old">
                            <?php
                            if ($target_con_rate > 1) {
                                $price = $products_recomend[$i]['price'] * $target_con_rate;
                                echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                            }

                            if ($target_con_rate <= 1) {
                                $price = $products_recomend[$i]['price'] * $target_con_rate;
                                echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                            }
                            ?>
                        </del>
                    <?php }else{ ?>
                        <span class="price-new">
                            <?php
                            if ($target_con_rate > 1) {
                                $price = $products_recomend[$i]['price'] * $target_con_rate;
                                echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                            }

                            if ($target_con_rate <= 1) {
                                $price = $products_recomend[$i]['price'] * $target_con_rate;
                                echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                            }
                            ?>
                        </span>
                    <?php } ?>
                </div> <!-- price-wrap.// -->
            </div> <!-- bottom-wrap.// -->
        </figure>
        </a>
    </div> <!-- col // -->
    <?php } ?>
</div> <!-- row.// -->
</div>

    <figure class="mt-5 banner bg-secondary">
        <div id="carouselpromo2" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/1.jpg')?>" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/2.jpg')?>" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="<?php echo base_url('assets/website/maqueta/images/banners/1.jpg')?>" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselpromo2" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselpromo2" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </figure>

</div> <!-- container .//  -->
</section>
<?php } ?>
<!-- ========================= SECTION RECOMENDACIONES END// ========================= -->
