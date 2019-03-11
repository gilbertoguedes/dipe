<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new unit start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('catalogue') ?></h1>
            <small><?php echo display('add_catalogue') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('catalogue') ?></a></li>
                <li class="active"><?php echo display('add_catalogue') ?></li>
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
                
                  <a href="<?php echo base_url('Ccatalogue/manage_catalogue')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_catalogue')?></a>

                </div>
            </div>
        </div>

        <!-- New unit -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_catalogue') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('Ccatalogue/insert_catalogue', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="catalogue_name" class="col-sm-3 col-form-label"><?php echo display('name')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                <input class="form-control" name ="catalogue_name" id="catalogue_name" type="text" placeholder="<?php echo display('name') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="catalogue_short_name" class="col-sm-3 col-form-label"><?php echo display('short_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="catalogue_short_name" id="catalogue_short_name" type="text" placeholder="<?php echo display('short_name') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="catalogue_description" class="col-sm-3 col-form-label"><?php echo display('description')?></label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="catalogue_description" id="catalogue_description"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-catalogue" class="btn btn-success btn-large" name="add-catalogue" value="<?php echo display('save') ?>" />
                                <!--<input type="submit" id="add-unit-another" class="btn btn-primary btn-large" name="add-unit-another" value="<?php echo display('save_and_add_another') ?>" />-->
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new unit end -->



