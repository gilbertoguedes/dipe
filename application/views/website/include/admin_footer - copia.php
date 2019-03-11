<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->model('Web_settings');
$CI->load->model('Companies');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$company_info  = $CI->Companies->company_list();
?>
<!--======== Footer Area ========-->
<footer>
    <div class="container">
        <div class="row footer_inner">
            <div class="col-lg-4 col-md-6 hidden-sm widget about_us_widget">

                <div class="footer_logo">
                    <a href="<?php echo base_url()?>">
                        <img src="<?php echo $Web_settings[0]['footer_logo']?>" alt="company-logo">
                    </a>
                </div>

                <p><?php echo display('footer_details')?></p>

                <address>
                    <p><?php echo display('address')?>: <?php echo $company_info[0]['address'];?></p>
                </address>
                <div class="contact_info">
                    <span><?php echo display('mobile')?>: </span><a href="#"><?php echo $company_info[0]['mobile'];?></a>
                </div>
                <div class="contact_info">
                    <span><?php echo display('email')?>: </span><a href="#"><?php echo $company_info[0]['email'];?></a> 
                </div>
                <div class="contact_info">
                    <span><?php echo display('website')?>: </span><a href="#"><?php echo $company_info[0]['website'];?></a>
                </div>
            </div>
            <?php
            if ($footer_block) {
                foreach ($footer_block as $footer) {
                    echo $footer->  details;
                }
            }
            ?>
            <!--<div class="widget widget2 widget_social_link col-md-6 col-lg-3">
                <h4 class="widget_title"><?php echo display('app_qr_code')?></h4>
                <div class="widget_inner row m0">
                    <a href="<?php echo 'https://play.google.com/store/apps/details?id=diepsa&site='.base_url().'&valid=Dipepsa';?>">
                        <img src="<?php echo base_url('my-assets/image/qr/dipepsa_qr.png')?>" class="img img-responsive" title="<?php echo display('app_qr_code')?>" style="height: 180px">
                    </a>
                </div>
            </div>-->
        </div>
    </div>
</footer>
<section class="footer_bottom">
    <div class="container">
        <div class="row footer_bottom_inner">
            <div class="col-lg-6 col-md-5 b_footer_left">
                <h6><?php if($Web_settings[0]['footer_text']){echo $Web_settings[0]['footer_text'];}?></h6>
            </div>
            <div class="col-lg-6 col-md-7 b_footer_right">
                <ul class="justify-content-end">
                    <li><h6><?php echo display('pay_with')?> :</h6></li>
                    <li><a href="#"><img src="<?php echo base_url()?>assets/website/image/atmcard/1.jpg" alt="#"></a></li>
                    <li><a href="#"><img src="<?php echo base_url()?>assets/website/image/atmcard/2.jpg" alt="#"></a></li>
                    <li><a href="#"><img src="<?php echo base_url()?>assets/website/image/atmcard/3.jpg" alt="#"></a></li>
                    <li><a href="#"><img src="<?php echo base_url()?>assets/website/image/atmcard/4.jpg" alt="#"></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--====== End Footer Area ======-->