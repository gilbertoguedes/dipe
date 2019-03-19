<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Bootstrap-ecommerce by Vosidiy">

    <title><?php echo $title; ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/website/maqueta/images/dipepsathumbnailico.ico')?>">

    <script src="<?php echo base_url('assets/website/vendor/jquery/jquery-3.2.1.min.js')?>" type="text/javascript"></script>

    <script src="<?php echo base_url('assets/bootstrap/js/validator.min.js')?>" type="text/javascript"></script>

    <!-- jquery-data-tables -->
    <script src="<?php echo base_url('assets/website/vendor/datatables/js/jquery.dataTables.min.js')?>" type="text/javascript"></script>
    <!-- EasyZoom -->
    <script src="<?php echo base_url('assets/website/vendor/easyzoom/easyzoom.min.js')?>" type="text/javascript"></script>

    <!-- Bootstrap4 files-->
    <script src="<?php echo base_url('assets/website/maqueta/js/bootstrap.bundle.min.js')?>" type="text/javascript"></script>
    <link href="<?php echo base_url('assets/website/maqueta/css/bootstrap.css')?>" rel="stylesheet" type="text/css"/>

    <!-- EasyZoom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/website/vendor/easyzoom/easyzoom.min.css')?>">

    <!-- Font awesome 5 -->
    <link href="<?php echo base_url('assets/website/maqueta/fonts/fontawesome/css/fontawesome-all.min.css')?>" type="text/css" rel="stylesheet">

    <!-- Include SmartWizard CSS -->
    <link href="<?php echo base_url('assets/website/vendor/SmartWizard-master/dist/css/smart_wizard.css')?>" rel="stylesheet" type="text/css">

    <!-- Optional SmartWizard theme -->
    <link href="<?php echo base_url('assets/website/vendor/SmartWizard-master/dist/css/smart_wizard_theme_dots.css')?>" rel="stylesheet" type="text/css">

    <!-- plugin: owl carousel  -->
    <link href="<?php echo base_url('assets/website/maqueta/plugins/owlcarousel/assets/owl.carousel.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/website/maqueta/plugins/owlcarousel/assets/owl.theme.default.css')?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/website/maqueta/plugins/owlcarousel/owl.carousel.min.js')?>"></script>

    <!-- plugin: slickslider -->
    <link href="<?php echo base_url('assets/website/maqueta/plugins/slickslider/slick.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/website/maqueta/plugins/slickslider/slick-theme.css')?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url('assets/website/maqueta/plugins/slickslider/slick.min.js')?>"></script>

    <!-- custom style -->

    <link href="<?php echo base_url('assets/website/maqueta/css/ui.css')?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url('assets/website/maqueta/css/responsive.css')?>" rel="stylesheet" media="only screen and (max-width: 1200px)" />
    <link href="<?php echo base_url('assets/website/maqueta/css/dipe-ui.css')?>" rel="stylesheet" type="text/css" />


    <!-- custom javascript -->
    <script src="<?php echo base_url('assets/website/maqueta/js/script.js')?>" type="text/javascript"></script>

    <!-- Bootstrap  -->
    <script src="<?php echo base_url('assets/website/vendor/bootstrap/js/tether.min.js')?>" type="text/javascript"></script>
    <!--<script src="<?php echo base_url('assets/website/vendor/bootstrap/js/bootstrap.min.js')?>" type="text/javascript"></script>-->



    <!-- Chat modulo  -->
    <script type="text/javascript" src="//condor1178.startdedicated.com/livechat/php/app.php?widget-init.js"></script>

    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="<?php echo base_url('assets/website/vendor/SmartWizard-master/dist/js/jquery.smartWizard.min.js')?>"></script>

    <!-- Owl Carousel -->
    <script src="<?php echo base_url('assets/website/vendor/owl-carousel/owl.carousel.min.js')?>" type="text/javascript"></script>

    <!-- DSCount JS -->
    <script src="<?php echo base_url('assets/website/vendor/dscountdown/dscountdown.min.js')?>" type="text/javascript"></script>

    <!-- WoW js -->
    <script src="<?php echo base_url('assets/website/vendor/wow-js/wow.min.js')?>"></script>

    <!-- Lightbox js -->
    <script src="<?php echo base_url('assets/website/vendor/lightbox/js/lightbox.min.js')?>"></script>

    <!-- Simple Share js -->
    <script src="<?php echo base_url('assets/website/js/jquery.simpleSocialShare.min.js')?>"></script>

    <!-- Custom scripts for this template -->
    <!--<script src="<?php echo base_url('assets/website/js/theme.js')?>"></script>-->

</head>
<body>
    <header class="section-header">
        <div id="loading-overlay">
            <img src="<?php echo base_url('my-assets/image/loading.gif')?>">
        </div>
        <?php  $this->load->view('website/include/admin_header'); ?>
        {content}
        <?php $this->load->view('website/include/admin_footer'); ?>
    </header> <!-- section-header.// -->

    <script type="text/javascript">

    $('body').on('change', '#select_store', function() {
        var store_id = $('#select_store').val();
        if (store_id == 0) {
            alert('Seleccione una Tienda');
            window.location.href = document.location.origin;
            /*return false;*/
        }

        $('#loading-overlay').fadeIn();

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
    });


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

    function product_search()
    {
        $store_id = $('#select_store').val();
        $product_name = $('#product_name').val();
        $cat_id = $('#select_category').val();
        if($product_name=='')
        {
            $product_name = 'all_products';
        }
        window.location.href = document.location.origin+'/category_product_search_url/'.concat($store_id).concat('/').concat($product_name).concat('/').concat($cat_id);
    }

    function cart_btn_one(product_id){
        var qnty       =  1;
        var variant    = $('#select_size1').val();
        var store_id   = $('#select_store').val();

        if (product_id == 0) {
            alert('<?php echo display('ooops_something_went_wrong')?>');
            return false;
        }

        if (variant != 'undefine') {
            if (variant <= 0) {
                alert('<?php echo display('please_select_product_size')?>');
                return false;
            }
        }

        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/add_to_cart_one_details')?>',
            data: {product_id:product_id,qnty:qnty,variant:variant,store_id:store_id},
            success: function(data) {
                if(data=="1") {
                    $("#tab_up_cart").load(location.href + " #tab_up_cart>*", "");
                }
                else
                {
                    alert('<?php echo display('there_are_not_the_Qnty_in_stock')?>');
                    return false;
                }

            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }

    /*valoraciones de la pagina de detalles*/

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

        //Review msg check
        if (review_msg == 0) {
            alert('Por favor, escriba un comentario !');
            return false;
        }

        //Customer id check
        if (customer_id == 0) {
            alert('Por favor, para evaluar el producto debe estar logueado');
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
        });
    });

    $('#product_name').on('keypress',function(e){
        if(e.which === 13)
        {
            product_search();
        }
    });

    /*--------------------------------------------------------------------------*/

    var $easyzoom = $('.easyzoom').easyZoom({
        loadingNotice:"Cargando Imagen",
        errorNotice:"Error al cargar la imagen"
    });

    // Setup thumbnails example
    var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

    $('.thumbnails').on('click', 'a', function(e) {
        var $this = $(this);

        e.preventDefault();

        // Use EasyZoom's `swap` method
        api1.swap($this.data('standard'), $this.attr('href'));
    });

   $(window).on("load",function(e){
      $('#loading-overlay').fadeOut();
   });

   function resizeHeaderOnScroll(){
       const distanceY = window.pageYOffset ||
       document.documentElement.scrollTop,
           shrinkOn = 100,
           dipeLogo = document.getElementById('dipe-logo')

       if(distanceY > shrinkOn)
       {
           dipeLogo.classList.add("dipe-logo-smaller");
           document.getElementById('dipe-address-store').classList.add('display-none');
           if(document.getElementById('dipe-welcome')!=null)
           {
               document.getElementById('dipe-welcome').classList.add('display-none');

           }
       }
       else
       {
           dipeLogo.classList.remove("dipe-logo-smaller");
           document.getElementById('dipe-address-store').classList.remove('display-none');
           if(document.getElementById('dipe-welcome')!=null)
           {
               document.getElementById('dipe-welcome').classList.remove('display-none');
           }
       }
   }

    window.addEventListener('scroll',resizeHeaderOnScroll);


    </script>
</body>
</html>
