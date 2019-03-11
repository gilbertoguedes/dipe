<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->model('Web_settings');
$CI->load->model('Companies');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$company_info  = $CI->Companies->company_list();
?>
<!-- ========================= FOOTER ========================= -->
<footer class="section-footer dipe-bg-1">
    <div class="depi-up col-12 text-center dipe-blue-1-bg dipe-gray-text-1-bg p-2"><i class="fas fa-arrow-up"></i><a href="#" class="p-2">Subir al inicio de página</a> </div>
    <div class="container">
        <section class="footer-bottom row justify-content-md-center p-5">
            <div class="dipe-footer-left-col col-sm-6 col-lg-5 text-right dipe-grayblue-text-1-bg pt-2 ">
                <p class="dipe-textsize-9"> <?php echo display('footer_details')?></p>
                <p class="dipe-textsize-9"><?php echo $company_info[0]['address'];?>
                    Teléfono Móvil: <?php echo $company_info[0]['mobile'];?>
                    Correo Electrónico: <a href="#"><?php echo $company_info[0]['email'];?></a></p>
            </div>
            <?php
            if ($footer_block) { ?>
                <div class="dipe-footer-right-col col-sm-6 col-lg-4">
                <?php foreach ($footer_block as $footer) { ?>
                    <ul class="dipe-gray-text-1-bg dipe-textsize-9">
                        <?php echo $footer->  details; ?>
                    </ul>
                }
                <?php }  ?>
                </div>
            <?php }  ?>
         </section> <!-- //footer-top -->
    </div><!-- //container -->
</footer>
<!-- ========================= FOOTER END // ========================= -->