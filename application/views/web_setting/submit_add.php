<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Submit add start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('add_advertise')?></h1>
            <small><?php echo display('add_new_advertise')?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home')?></a></li>
                <li><a href="#"><?php echo display('web_settings')?></a></li>
                <li class="active"><?php echo display('add_advertise')?></li>
            </ol>
        </div>
    </section>

    <section class="content">

        <!-- Alert Message -->
        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            if (isset($error_message)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }

        if (validation_errors()) {
            ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo validation_errors(); ?>
        </div>
        <?php
            }
        ?>

        
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                
                  <a href="<?php echo base_url('Cweb_setting/manage_add')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_advertise')?></a>

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_advertise')?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cweb_setting/submit_add/',array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="add_page" class="col-sm-3 col-form-label"><?php echo display('add_page')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="add_page" name="add_page" required="">
                                    <option></option>
                                    <option value="home"><?php echo display('home')?></option>
                                    <option value="category"><?php echo display('category')?></option>
                                    <option value="details"><?php echo display('details')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ads_position" class="col-sm-3 col-form-label"><?php echo display('ads_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="ads_position" class="form-control" type="number" placeholder="<?php echo display('ads_position')?>" id="ads_position" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ad_type" class="col-sm-3 col-form-label"><?php echo display('add_type')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                               <select name="ad_type" class="form-control" id="ad_type" required="1">
                                    <option value=""><?php echo display('select_one')?></option>
                                    <option value="1"><?php echo display('embed_code')?></option>
                                    <option value="2"><?php echo display('image_ads')?></option>
                                </select>
                            </div>
                        </div>   

                        <div class="form-group row embed_code_ad" style="display: block;">
                            <label for="embed_code" class="col-sm-3 col-form-label"><?php echo display('embed_code')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                               <textarea name="add_code" class="form-control" placeholder="<?php echo display('embed_code')?>" id="embed_code"></textarea>
                            </div>
                        </div> 

                        <div class="img_ad" style="display: none;">
                            <div class="form-group row" >
                                <label for="image" class="col-sm-3 col-form-label"><?php echo display('image')?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                   <input name="add_image" class="form-control" type="file" id="image">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="add_url" class="col-sm-3 col-form-label"><?php echo display('url')?> <i class="text-danger">*</i></label>
                                <div class="col-sm-6">
                                   <input name="add_url" class="form-control" type="url" placeholder="<?php echo display('url')?>" id="add_url">
                                </div>
                            </div> 
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <button type="reset" class="btn btn-danger"><?php echo display('reset')?></button>
                                <button type="submit" class="btn btn-success"><?php echo display('submit')?></button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Submit add end -->



<!--Select ads type by javascript start-->
<script type="text/javascript">
    $(document).ready(function() {
        $('.img_ad').css({'display': 'none'});
        $('.embed_code_ad').css({'display': 'none'});

        $('#ad_type').on('change', function() {
            var ad_type = $('#ad_type option:selected').val();
            if (ad_type == 1) {
                $('.img_ad').css({'display': 'none'});
                $('.embed_code_ad').css({'display': 'block'});
            }
            else if (ad_type == 2) {
                $('.img_ad').css({'display': 'block'});
                $('.embed_code_ad').css({'display': 'none'});
            }
            else {
                $('.img_ad').css({'display': 'none'});
                $('.embed_code_ad').css({'display': 'none'});
            }
        });
    });
</script>
<!--Select ads type by javascript end-->
