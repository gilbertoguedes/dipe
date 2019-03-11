<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('category') ?></h1>
            <small><?php echo display('add_new_category_department') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('category') ?></a></li>
                <li class="active"><?php echo display('add_category_department') ?></li>
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
        ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                
                  <a href="<?php echo base_url('Ccategory/manage_category_department')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_category_department')?></a>

                </div>
            </div>
        </div>

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_category_department') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Ccategory/insert_category_department', array('class' => 'form-vertical','id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('category_department_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="category_name" id="category_name" type="text" placeholder="<?php echo display('category_department_name') ?>"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('category_clave')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="category_clave" id="category_clave" type="text" placeholder="<?php echo display('category_clave') ?>"  required="">
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="top_menu" class="col-sm-4 col-form-label"><?php echo display('top_menu')?></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="top_menu" id="top_menu">
                                    <option value=""></option>
                                    <option value="1"><?php echo display('yes')?></option>
                                    <option value="0"><?php echo display('no')?></option>
                                </select>
                            </div>
                        </div>

                        <!--<div class="form-group row">
                            <label for="menu_position" class="col-sm-4 col-form-label"><?php echo display('menu_position')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="menu_position" id="menu_position" type="text" placeholder="<?php echo display('menu_position') ?>" value="0"  required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cat_favicon" class="col-sm-4 col-form-label"><?php echo display('cat_icon')?></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="cat_favicon" id="cat_favicon" type="file">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cat_image" class="col-sm-4 col-form-label"><?php echo display('cat_image')?> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="cat_image" id="cat_image" type="file">
                                <span class="help-block small"><?php echo display('optional') ?></span>
                            </div>
                        </div>-->
                
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save') ?>" />
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



