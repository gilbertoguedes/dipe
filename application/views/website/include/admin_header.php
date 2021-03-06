<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
    /* Set the width of the side navigation to 250px */
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>

<div class="dipe-header-fixed-top">


<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="dipe-accede-regist-mobile">
    <a href="<?php echo base_url().'login'?>" class="d-inline p-0">Accede</a>
        <span class="dipe-mobile-vertical-separator"><span class="split-line">|</span></span>
    <a href="<?php echo base_url().'signup'?>" class="d-inline p-0">Regístrate</a>
    </div>
    <div class="dipe-separator-line"></div>
    <a href="<?php echo base_url()?>"><i class="fas fa-home mr-3"></i>Portada</a>
    <div class="dipe-separator-line"></div>
    <a href="/all_category">Categorías</a>
    <a href="/product_new">Nuevos Productos</a>
    <a href="/popular_category">Populares</a>
    <a href="/product_oferts">En Ofertas</a>
    <a href="/product_recomend">Recomendaciones</a>
    <a href="/stores">Sucursales</a>
</div>

<div class="dipe-header-mobile-bar d-lg-none">
    <a class="dipe-header-item" onclick="openNav()">
        <i class="fas fa-bars"></i>
    </a>
    <a class="dipe-header-item dipe-logo-mobile" href="<?php echo base_url().'/Admin_dashboard';?>">
        <img src="/assets/website/maqueta/images/logo-dipepsa.png" alt="Logo Dipepsa">
    </a>
    <a href="<?php echo base_url('view_cart')?>" class="dipe-header-item dipe-carrito-mobile"><i class="fas fa-shopping-cart"></i></a>
</div>



<section class="header-main dipe-header-main dipe-shadow">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4-24 col-sm-5 col-4 d-none d-lg-block">
                <div class="brand-wrap">
                    <a href="<?php echo base_url().'/Admin_dashboard';?>">
                    <img id="dipe-logo" class="dipe-logo logo" src="/assets/website/maqueta/images/logo-dipepsa.png">
                    </a>
                    <!--<h2 class="logo-text">LOGO</h2>-->
                </div> <!-- brand-wrap.// -->
            </div>
            <div class="col-lg-14-24 col-sm-12 order-3 order-lg-2 ">
                <?php /* echo form_open('category_product_search')*/ ?>
                    <div class="input-group w-100">
                        <?php
                        $storeId = "";
                        $nameStore = "";
                        $nameStoreShow = "";
                        $addresStoreshow = "";

                        if($this->session->has_userdata('store_id'))
                        {
                            if($storeId = $this->session->userdata('store_id')=='' || $storeId = $this->session->userdata('store_id')=='0')
                            {
                                $storeId = $store_default;
                                $this->session->set_userdata('store_id',$storeId);
                                redirect(base_url());
                            }
                            $storeId = $this->session->userdata('store_id');
                        }
                        else
                        {
                            $storeId = $store_default;
                            $this->session->set_userdata('store_id',$storeId);
                        }

                        ?>
                        <select class="custom-select  dipe-custom-select"  name="store_id" id="select_store">
                            <?php if ($stores) {
                                foreach ($stores as $sto) {
                                    ?>
                                    <?php if($sto['store_id'] == $storeId){  ?>
                                        <option selected value="<?php echo $sto['store_id']?>"><?php $nameStore = $sto['store_name']; $nameStore = strtolower($nameStore); $nameStore = ucfirst($nameStore); echo $nameStore; $nameStoreShow = $nameStore; $addresStoreshow = $sto['store_address']; $addresStoreshow = strtolower($addresStoreshow); $addresStoreshow = ucfirst($addresStoreshow); ?></option>
                                    <?php }else{  ?>
                                        <option value="<?php echo $sto['store_id']?>"><?php $nameStore = $sto['store_name']; $nameStore = strtolower($nameStore); $nameStore = ucfirst($nameStore); echo $nameStore; ?></option>
                                    <?php } ?>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <select class="custom-select  dipe-custom-select"  name="category_id" id="select_category">
                            <option value="all"><?php echo display('all_categories')?></option>
                            <?php if ($pro_category_list) {
                                foreach ($pro_category_list as $pr_cat_list) {
                                    ?>
                                    <option value="<?php echo $pr_cat_list['category_id']?>"><?php echo $pr_cat_list['category_name']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <input type="text" class="form-control dipe-input-search dipe-remove-background-clip" name="product_name" id="product_name"   placeholder="">

                        <div class="input-group-append">
                            <button class="btn dipe-btn-primary btn-primary" type="button" onclick="product_search()">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                <?php /*echo form_close()*/ ?>
            </div> <!-- col.// -->
            <div class="col-lg-6-24 col-sm-7 col-8  order-2  order-lg-3 d-none d-lg-block">
                <div class="d-flex justify-content-end">
                    <div class="widget-header dipe-pt-9px">
                        <!--<small class="title dipe-text-muted text-muted">Javier Alejandro !</small>-->
                        <?php if (! $this->user_auth->is_logged()) { ?>
                        <div> <a href="<?php echo base_url().'signup'?>" class="btn ml-2 dipe-btn-warning btn-warning">Regístrate</a> <!--<a href="#">Sign in</a> <span class="dark-transp"> |--> </span>
                            <!--<a href="#"> Register</a></div>-->
                            <a href="<?php echo base_url().'login'?>" class="btn ml-2 dipe-btn-warning btn-warning">Accede</a>
                        </div>
                        <?php }else{ ?>
                        <label id="dipe-welcome" class="dipe-welcome"><?php echo display('welcome'); ?> <?php echo $this->session->userdata('customer_name'); ?> a <h4 id="store_name"><?php echo $nameStoreShow; ?></h4> </label>
                        <?php } ?>
                    </div>
                    <!--<div class="dropdown">
                        <a href="<?php echo base_url().'/view_cart'; ?>" class="widget-header pl-2 ml-2 tab_up_cart" id="tab_up_cart">
                            <div class="icontext dipe-icontext">
                                <div class="dipe-icon-wrap icon-wrap icon-sm round dipe-border border"><i class="fa fa-shopping-cart"></i></div>
                            </div>
                            <span class="badge badge-pill badge-danger dipe-notify notify"><?php echo $this->cart->total_items()?></span>
                        </a>
                    </div>-->
                    <div class="dipe-dropdown dropdown" id="tab_up_cart">
                        <a role="button" data-toggle="dropdown" data-display="static" href="#" class="widget-header pl-2 ml-2 tab_up_cart">
                            <div class="icontext dipe-icontext">
                                <div id="card-icon" class="dipe-icon-wrap icon-wrap icon-sm round dipe-border border"><i class="fa fa-shopping-cart"></i></div>
                            </div>
                            <span class="badge badge-pill badge-danger dipe-notify notify"><?php echo $this->cart->total_items()?></span>
                        </a>
                        <!--<button type="button" class="btn btn-info" data-toggle="dropdown">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">3</span>
                        </button>-->
                        <div class="dipe-dropdown-menu dropdown-menu">
                            <div class="row dipe-total-header-section">
                                <div class="col-lg-6 col-sm-6 col-6">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger"><?php echo $this->cart->total_items()?></span>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-6 dipe-total-section total-section text-right">
                                    <p>Total: <span class="text-info"><?php echo (($position==0)?$currency.' '.number_format($this->cart->total(), 2, '.', ','):number_format($this->cart->total(), 2, '.', ',').' '.$currency)?></span></p>
                                </div>
                            </div>
                            <?php if ($this->cart->contents()) { ?>
                            <?php foreach ($this->cart->contents() as $items){ ?>
                            <div class="row dipe-cart-detail cart-detail">
                                <div class="col-lg-4 col-sm-4 col-4 dipe-cart-detail-img cart-detail-img">
                                    <img src="<?php echo $items['options']['image']?>" alt="Awesome Image">
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8 dipe-cart-detail-product">
                                    <p><?php echo $items['name']; ?></p>
                                    <span class="price text-info"> <?php echo (($position==0)?$currency.' '.$this->cart->format_number($items['price']):$this->cart->format_number($items['price']).' '.$currency) ?></span>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                    <a href="<?php echo base_url('checkout')?>" class="btn btn-primary btn-block"><?php echo display('checkout')?></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12 text-center checkout" style="margin-top: 5px">
                                    <a href="<?php echo base_url('view_cart')?>" class="btn btn-primary btn-block"><?php echo display('view_cart')?></a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div> <!-- widgets-wrap.// -->
                <div id="dipe-address-store" class="d-flex justify-content-end">
                    <label class="dipe-address-store"> <?php echo $addresStoreshow; ?> </label>
                </div>
            </div> <!-- col.// -->
        </div> <!-- row.// -->
    </div> <!-- container.// -->
</section> <!-- header-main .// -->
<nav class="navbar navbar-expand-lg dipe-navbar-dark navbar-dark dipe-bg-secondary bg-secondary shadow-sm  d-none d-lg-block ">
    <div class="container-fluid dipe-top-header-menu">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>



            <div class=" collapse navbar-collapse dipe-textsize-9" id="main_nav">
            <ul class="navbar-nav mr-auto ">
                <li class="nav-item dipe-border-l dipe-border-rb pb-0 <?php if ($this->uri->segment('1') == ("all_category")) { echo "nav-item-popular";} ?> px-1 ">
                    <a class="nav-link  dipe-nav-link" href="/all_category"><i class="fa  fa-caret-right"></i> Categorías </a>
                </li>
                <li class="nav-item dipe-border-rb pb-0 <?php if ($this->uri->segment('1') == ("product_new")) { echo "nav-item-popular";} ?> px-1">
                    <a class="nav-link dipe-nav-link" href="/product_new"><i class="fa  fa-caret-right"></i> Nuevos Productos</a>
                </li>
                <li class="nav-item dipe-border-rb pb-0 <?php if ($this->uri->segment('1') == ("popular_category")) { echo "nav-item-popular";} ?> px-1">
                    <a class="nav-link dipe-nav-link" href="/popular_category"><i class="fa  fa-caret-right"></i> Populares</a>
                </li>
                <li class="nav-item dipe-border-rb pb-0 <?php if ($this->uri->segment('1') == ("product_oferts")) { echo "nav-item-popular";} ?> px-1">
                    <a class="nav-link dipe-nav-link" href="/product_oferts"><i class="fa  fa-caret-right"></i> En Ofertas</a>
                </li>
                <li class="nav-item dipe-border-rb pb-0 <?php if ($this->uri->segment('1') == ("product_recomend")) { echo "nav-item-popular";} ?> px-1">
                    <a class="nav-link dipe-nav-link" href="/product_recomend"><i class="fa  fa-caret-right"></i> Recomendaciones</a>
                </li>
                <li class="nav-item dipe-border-rb pb-0 <?php if ($this->uri->segment('1') == ("stores")) { echo "nav-item-popular";} ?> px-1">
                    <a class="nav-link dipe-nav-link" href="/stores"><i class="fa  fa-map-marker-alt"></i> Sucursales</a>
                </li>
                <!--<li class="nav-item dipe-border-rb pb-0 px-1">
                    <a class="nav-link dipe-nav-link" href="paypal.com"><i class="fa  fa-caret-right"></i> Métodos de Envío</a>
                </li>-->
            </ul>
            <?php if ( $this->user_auth->is_logged()) { ?>
            <ul class="navbar-nav">
                <li class="nav-item dipe-border-l">
                    <a class="nav-link dipe-nav-link" href="<?php echo base_url().'customer/customer_dashboard'?>"><i class="fa  fa-user"></i> Mi cuenta</a>
                </li>
                <li class="nav-item dipe-border-rl">
                    <a class="nav-link dipe-nav-link" href="<?php echo base_url('logout')?>"><i class="fa  fa-sign-out-alt"></i> Salir</a>
                </li>
            </ul>
            <?php } ?>
        </div> <!-- collapse .// -->

        </div>
    </div> <!-- container .// -->




</nav>
</div>