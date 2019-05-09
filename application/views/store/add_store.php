<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('store') ?></h1>
            <small><?php echo display('add_store') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('store') ?></a></li>
                <li class="active"><?php echo display('add_store') ?></li>
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
            $validatio_error = validation_errors();
            if (($error_message || $validatio_error)) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $error_message ?>                    
            <?php echo $validatio_error ?>                    
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                
                  <a href="<?php echo base_url('Cstore/manage_store')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_store')?></a>
                  <!--<a href="<?php echo base_url('Cstore/store_transfer')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('store_transfer')?></a>-->
                  <!--<a href="<?php echo base_url('Cstore/manage_store_product')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_store_product')?></a>-->

                   <button type="button" class="btn btn-danger m-b-5 m-r-2"><?php echo display('you_must_have_a_default_store')?></button>

                </div>
            </div>
        </div>

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_store') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('Cstore/insert_store', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="store_name" class="col-sm-3 col-form-label"><?php echo display('store_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="store_name" id="store_name" type="text" placeholder="<?php echo display('store_name') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"><?php echo "Catálogo";?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="catalogue_id" required>
                                    <option value=""><?php echo display('select_options')?></option>
                                    <?php if($catalogues_list){ ?>
                                        {catalogues_list}
                                        <option value="{catalogue_id}">{catalogue_name}</option>
                                        {/catalogues_list}
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_address" class="col-sm-3 col-form-label"><?php echo display('store_address')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="store_address" id="store_address" type="text" placeholder="<?php echo display('store_address') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_zip" class="col-sm-3 col-form-label"><?php echo 'Código zip'; ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="zip" id="store_zip" type="text" placeholder="<?php echo 'Código zip'; ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_lat" class="col-sm-3 col-form-label"><?php echo 'Latitud'; ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="lat" id="store_lat" type="text" placeholder="<?php echo 'Latitud'; ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_lng" class="col-sm-3 col-form-label"><?php echo 'Longitud'; ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="lng" id="lng" type="text" placeholder="<?php echo 'Longitud'; ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"><?php echo 'Activado';?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="activate" required="" name="activate">
                                    <option value=""></option>
                                    <option value="1"><?php echo display('yes')?></option>
                                    <option value="0"><?php echo display('no')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"><?php echo display('default_status')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" id="default_status" required="" name="default_status">
                                    <option value=""></option>
                                    <option value="1"><?php echo display('yes')?></option>
                                    <option value="0"><?php echo display('no')?></option>
                               </select>
                               <span class="help-block small"><?php echo display('do_you_want_make_it_default_store')?></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-store" class="btn btn-success btn-large" name="add-store" value="<?php echo display('save') ?>" />
                                <!--<input type="submit" id="add-store-another" class="btn btn-primary btn-large" name="add-store-another" value="<?php echo display('save_and_add_another') ?>" />-->
                            </div>
                        </div> 
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->



