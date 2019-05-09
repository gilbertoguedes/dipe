<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit User start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('user_edit') ?></h1>
            <small><?php echo display('user_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li class="active"><?php echo display('user_edit') ?></li>
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

        <!-- New user -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('user_edit') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('User/user_update',array('class' => 'form-vertical','id' => 'validate' ))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="1" class="form-control" name="first_name" value="{first_name}"  placeholder="<?php echo display('first_name') ?>" required />
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="last_name" class="col-sm-3 col-form-label"><?php echo display('last_name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="2" class="form-control" name="last_name" value="{last_name}"  placeholder="<?php echo display('last_name') ?>" required />
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" tabindex="3" id="email" class="form-control" name="username" value="{username}"  placeholder="<?php echo display('email') ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="password" tabindex="4" id="password" class="form-control" name="password" placeholder="<?php echo display('password') ?>" />

                                <input type="hidden" name="old_password" value="{password}" />

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label"><?php echo display('status') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="status" required="" tabindex="5" id="status">
                                    <option value="0"><?php echo display('select_one') ?></option>
                                    <option value="1" <?php if ($status == 1) { echo "selected";}?>><?php echo display('active') ?></option>
                                    <option value="0" <?php if ($status == 0) { echo "selected";}?>><?php echo display('inactive') ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_type" class="col-sm-3 col-form-label"><?php echo display('user_type') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="user_type" required="" tabindex="5" id="user_type">
                                    <option value="0" <?php if ($user_type == 0) { echo "selected";}?>><?php echo display('select_one') ?></option>
                                    <option value="2" <?php if ($user_type == 2) { echo "selected";}?>><?php echo display('user') ?></option>
                                    <option value="4" <?php if ($user_type == 4) { echo "selected";}?>><?php echo display('store_keeper') ?></option>
                                </select>
                            </div>
                        </div>

                        <style type="text/css">
                            <?php if ($user_type == 4) { echo "#payment_from_1{display: block;}";}else{ echo "#payment_from_1{display: none;}"; } ?>
                        </style>

                        <div class="form-group row" id="payment_from_1">
                            <label for="store" class="col-sm-3 col-form-label"><?php echo display('store') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="store_id" id="store_id" required="" style="width: 100%">
                                    <option value=""></option>
                                    <?php 
                                    if ($store_list) {
                                        foreach ($store_list as $store) {
                                    ?>
                                    <option value="<?php echo $store['store_id']?>" <?php if ($store_id == $store['store_id'] ) {echo "selected";}?>><?php echo $store['store_name']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                  </select>
                            </div>
                        </div>

                        <script type="text/javascript">
                            //Active/Inactive store
                            $('body').on('change', '#user_type', function() {
                                var user_type = $(this).val();
                                if (user_type == 4) {
                                    document.getElementById("payment_from_1").style.display="block";
                                }else{
                                    document.getElementById("payment_from_1").style.display="none";
                                }
                            });
                        </script>

                        <input type="hidden" name="user_id" value="{user_id}" />

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-Customer" class="btn btn-success btn-large" name="add-Customer" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit user end -->



