<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php
            $CI =& get_instance();
            $CI->load->model('Web_settings');
            $CI->load->model('Companies');
            $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
            $company_info  = $CI->Companies->company_list();
        ?>
        <meta name="author" content="<?php if($company_info['0']['company_name']){echo $company_info['0']['company_name'];}?>">
        <meta name="description" content="">

        <title><?php echo (isset($title)) ? $title :"Style Dunea" ?></title>
   
        <!-- Favicons --> 
        <link rel="icon" type="image/png" href="<?php if (isset($Web_settings[0]['logo'])){ echo $Web_settings[0]['favicon']; }?>">
        
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url('assets/website/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">  
        
        <!-- FontAwesome Icon CSS -->
        <link href="<?php echo base_url('assets/website/vendor/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css"> 
        
        <!-- Jquery UI CSS -->
        <link href="<?php echo base_url('assets/website/vendor/jquery-ui/jquery-ui.min.css')?>" rel="stylesheet"> 
		
		<!-- DataTable CSS -->
        <link href="<?php echo base_url('assets/website/vendor/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet"> 
        
        <!-- Owl Carousel CSS -->
        <link href="<?php echo base_url('assets/website/vendor/owl-carousel/owl.carousel.min.css')?>" rel="stylesheet">
        
        <!-- Animate CSS -->
        <link href="<?php echo base_url('assets/website/vendor/wow-js/animate.css')?>" rel="stylesheet"> 
        
        <!-- Lightbox CSS -->
        <link href="<?php echo base_url('assets/website/vendor/lightbox/css/lightbox.min.css')?>" rel="stylesheet">
		
		

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url('assets/website/css/style.css')?>" rel="stylesheet"> 
        <!-- EasyZoom CSS -->
        <link rel="stylesheet" href="<?php echo base_url('assets/website/vendor/easyzoom/easyzoom.css')?>">

        <!-- Responsive Style -->
        <link href="<?php echo base_url('assets/website/css/responsive.css')?>" rel="stylesheet">

        <!-- Include SmartWizard CSS -->
        <link href="<?php echo base_url('assets/website/vendor/SmartWizard-master/dist/css/smart_wizard.css')?>" rel="stylesheet" type="text/css">

        <!-- Optional SmartWizard theme -->
        <link href="<?php echo base_url('assets/website/vendor/SmartWizard-master/dist/css/smart_wizard_theme_dots.css')?>" rel="stylesheet" type="text/css">

        <!-- Jquery  -->
        <script src="<?php echo base_url('assets/website/vendor/jquery/jquery-3.2.1.min.js')?>" type="text/javascript"></script>

        <!-- jquery-ui.min.js -->
        <script src="<?php echo base_url('assets/website/vendor/jquery-ui/jquery-ui.min.js')?>" type="text/javascript"></script>

		<!-- jquery-data-tables -->
        <script src="<?php echo base_url('assets/website/vendor/datatables/js/jquery.dataTables.min.js')?>" type="text/javascript"></script>
		
		
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        <!--==== Preloader =======-->
        <div class="preloader"></div>

        <!--========== Header Top Area ==========-->
        <div class="header_top">
            <div class="container">
                <div class="row m0 header_top_inner">
                    <div class="col-lg-6 hidden-md-down">
                        <div class="row connect_area">
                            <div class="connectus">
                                <a href="#"><i class="fa fa-phone"></i> <?php echo display('call_us') ?> : <?php echo $company_info[0]['mobile']?></a>
                            </div>
                            <div class="connectus">
                                <a href="#"><i class="fa fa-envelope-o"></i> <?php echo display('email') ?> : <?php echo $company_info[0]['email']?></a>
                            </div>
                        </div>
                    </div>
       
                    <div class="col-lg-6">
                        <div class="row changing_area justify-content-end justify-content-center-sm">
                            <!--<div class="l_change">
                                <span class="hidden-md-down"><?php echo display('language'); ?>: </span><?php
                                $user_lang = $this->session->userdata('language');
                                echo form_dropdown('language', $languages, $user_lang,'id="change_language"'); ?>
                            </div>-->
                            <?php if ( $this->user_auth->is_logged()) { ?>
                                <div class="hidden-md-down">
                                    <h5><?php echo display('welcome'); ?> : <?php echo $this->session->userdata('customer_name'); ?></h5>
                                </div>
                            <?php } ?>
                            <!--<div class="m_change">
                                <span class="hidden-md-down"><?php echo display('currency') ?>:</span>
                                <select id="change_currency" name="change_currency">
                                    <?php
                                    $currency_new_id = $this->session->userdata('currency_new_id');
                                    if ($currency_info) {
                                        foreach ($currency_info as $currency) {
                                    ?>
                                    <option value="<?php echo $currency->currency_id?>" <?php 
                                    if (!empty($currency_new_id)) {
                                        if ($currency->currency_id == $currency_new_id ){echo "selected";
                                        }
                                    }else{
                                        if ($currency->currency_id == $selected_cur_id ){echo "selected";
                                        }
                                    }
                                    ?>><?php echo $currency->currency_name?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>-->
                            <ul class="login_option hidden-lg-up">
								<?php if ( !$this->user_auth->is_logged()) { ?>
                                <li><a href="<?php echo base_url('login')?>" class="go_btn"><?php echo display('login')?></a></li>
                                <?php } ?>
								<?php if ( !$this->user_auth->is_logged()) { ?>
								<li><a href="<?php echo base_url('signup')?>" class="go_btn"><?php echo display('sign_up')?></a></li>
								<?php } ?>
								<?php if ( $this->user_auth->is_logged()) { ?>
								<li><a href="<?php echo base_url().'customer/customer_dashboard'?>" class="go_btn"><?php echo display('admin_dashboard') ?></a></li>
								<?php } ?>
								<?php if ( $this->user_auth->is_logged()) { ?>
								<li><a href="<?php echo base_url('logout')?>" class="go_btn"><?php echo display('logout') ?></a></li>
								<?php } ?>
							</ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--========== End Header Top Area ==========-->
        
        <?php  $this->load->view('website/include/admin_header'); ?>
            {content}
        <?php $this->load->view('website/include/admin_footer'); ?>
        
        <a href="#0" class="cd-top">
            <i class="fa fa-arrow-up"></i>
        </a>

        <!-- Incluciones js maqueta  -->
        <!-- <script src="<?php echo base_url('assets/website/maqueta/js/jquery-2.0.0.min.js')?>" type="text/javascript"></script> -->
        <script src="<?php echo base_url('assets/website/maqueta/js/bootstrap.bundle.min.js')?>" type="text/javascript"></script>
        <!--  ------------------------------------------------------------  -->

        <!-- Bootstrap  -->
        <script src="<?php echo base_url('assets/website/vendor/bootstrap/js/tether.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/website/vendor/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>

        <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>-->
        <script src="<?php echo base_url('assets/bootstrap/js/validator.min.js')?>" type="text/javascript"></script>

        <!-- Chat modulo  -->
        <script type="text/javascript" src="//condor1178.startdedicated.com/livechat/php/app.php?widget-init.js"></script>

        <!-- Include SmartWizard JavaScript source -->
        <script type="text/javascript" src="<?php echo base_url('assets/website/vendor/SmartWizard-master/dist/js/jquery.smartWizard.min.js')?>"></script>

        <!-- Owl Carousel -->
        <script src="<?php echo base_url('assets/website/vendor/owl-carousel/owl.carousel.min.js')?>" type="text/javascript"></script>

        <!-- EasyZoom -->
        <script src="<?php echo base_url('assets/website/vendor/easyzoom/easyzoom.js')?>" type="text/javascript"></script>

        <!-- DSCount JS -->
        <script src="<?php echo base_url('assets/website/vendor/dscountdown/dscountdown.min.js')?>" type="text/javascript"></script>
        
        <!-- WoW js -->
        <script src="<?php echo base_url('assets/website/vendor/wow-js/wow.min.js')?>"></script>
        
        <!-- Lightbox js -->
        <script src="<?php echo base_url('assets/website/vendor/lightbox/js/lightbox.min.js')?>"></script>  

        <!-- Simple Share js -->
        <script src="<?php echo base_url('assets/website/js/jquery.simpleSocialShare.min.js')?>"></script>

        <!-- Custom scripts for this template -->
        <script src="<?php echo base_url('assets/website/js/theme.js')?>"></script>

        <script type="text/javascript">

            //Simple share
            $('.share-button').simpleSocialShare();

            $( "#select_store").selectmenu({
                width: 250,
                icons: { button: "ui-icon-caret-1-s" },
                change:function(event,uri){
                    var store_id  = uri.item.value
                    $.ajax({
                        type: "post",
                        async: true,
                        url: '<?php echo base_url('website/Home/change_store')?>',
                        data: {store_id:store_id},
                        success: function(data) {
                            window.location.href = document.location.origin;
                        },
                        error: function() {
                            alert('Error al cambiar de Tienda, contacte con su administrador');
                        }
                    });
                }
            });


            
            //Change language ajax
            $('body').on('change', '#change_language', function() {
                var language  = $('#change_language').val();
                $.ajax({
                    type: "post",
                    async: true,
                    url: '<?php echo base_url('website/Home/change_language')?>',
                    data: {language:language},
                    success: function(data) {
                        if (data == 2) {
                            location.reload();
                        }else{
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Request Failed, Please check your code and try again!');
                    }
                });
            });



            //Change currency ajax
            $('body').on('change', '#change_currency', function() {
                var currency_id  = $('#change_currency').val();
                $.ajax({
                    type: "post",
                    async: true,
                    url: '<?php echo base_url('website/Home/change_currency')?>',
                    data: {currency_id:currency_id},
                    success: function(data) {
                        if (data == 2) {
                            location.reload();
                        }else{
                            location.reload();
                        }
                    },
                    error: function() {
                        alert('Request Failed, Please check your code and try again!');
                    }
                });
            }); 

            //Add to cart by ajax
            function add_to_cart(id){
                var product_id = $('#product_id_'+id).val();
                var price      = $('#price_'+id).val();
                var discount   = $('#discount_'+id).val();
                var qnty       = $('#qnty_'+id).val();
                var image      = $('#image_'+id).val();
                var name       = $('#name_'+id).val();
                var model      = $('#model_'+id).val();
                var supplier_price      = $('#supplier_price_'+id).val();
                var cgst      = $('#cgst_'+id).val();
                var cgst_id   = $('#cgst_id_'+id).val();
                var sgst      = $('#sgst_'+id).val();
                var sgst_id   = $('#sgst_id_'+id).val();
                var igst      = $('#igst_'+id).val();
                var igst_id   = $('#igst_id_'+id).val();

                if (product_id == 0) {
                    alert('<?php echo display('ooops_something_went_wrong')?>');
                    return false;
                }
                $.ajax({
                    type: "post",
                    async: true,
                    url: '<?php echo base_url('website/Home/add_to_cart')?>',
                    data: {
                        product_id:product_id,
                        price:price,
                        discount:discount,
                        qnty:qnty,
                        image:image,
                        name:name,
                        model:model,
                        supplier_price:supplier_price,
                        cgst:cgst,
                        cgst_id:cgst_id,
                        sgst:sgst,
                        sgst_id:sgst_id,
                        igst:igst,
                        igst_id:igst_id,
                    },
                    beforeSend: function(){
                        $('.preloader').html("<img src='<?php echo base_url('assets/website/image/loader.gif')?>'>");
                    },
                    success: function(data) {
                        $("#tab_up_cart").load(location.href+" #tab_up_cart>*","");
                    },
                    error: function() {
                        alert('Request Failed, Please check your code and try again!');
                    }
                });
            }

            //Add to cart by ajax
            function cart_btn(product_id){
                var qnty       = $('#sst').val();
                var variant    = $('#select_size1').val();
                var stock      = $('#stok').val();

                if (product_id == 0) {
                    alert('<?php echo display('ooops_something_went_wrong')?>');
                    return false;
                }
                if (qnty <= 0) {
                    alert('<?php echo display('please_keep_quantity_up_to_zero')?>');
                    return false;
                }

                if (variant != 'undefine') {
                    if (variant <= 0) {
                        alert('<?php echo display('please_select_product_size')?>');
                        return false;
                    }
                }

                if(parseInt(qnty)>stock){
                    alert('<?php echo display('there_are_not_the_Qnty_in_stock')?>');
                    return false;
                }
                
                $.ajax({
                    type: "post",
                    async: true,
                    url: '<?php echo base_url('website/Home/add_to_cart_details')?>',
                    data: {product_id:product_id,qnty:qnty,variant:variant},
                    success: function(data) {
                        $("#tab_up_cart").load(location.href+" #tab_up_cart>*","");
                    },
                    error: function() {
                        alert('Request Failed, Please check your code and try again!');
                    }
                });
            }
        </script>
    </body>

</html>
