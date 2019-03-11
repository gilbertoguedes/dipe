<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('terminal_edit') ?></h1>
            <small><?php echo display('terminal_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('terminal') ?></a></li>
                <li class="active"><?php echo display('terminal_edit') ?></li>
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

        <!--Edit terminal -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('terminal_edit') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('Cterminal/terminal_update/{pay_terminal_id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="terminal_name" class="col-sm-3 col-form-label"><?php echo display('terminal_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="terminal_name" id="terminal_name" type="text" placeholder="<?php echo display('terminal_name') ?>"  required="" value="{terminal_name}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="terminal_company" class="col-sm-3 col-form-label"><?php echo display('terminal_company')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="terminal_company" id="terminal_company" type="text" placeholder="<?php echo display('terminal_company') ?>"  required="" value="{terminal_provider_company}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="terminal_bank_account" class="col-sm-3 col-form-label"><?php echo display('terminal_bank_account')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="terminal_bank_account" id="terminal_bank_account" type="text" placeholder="<?php echo display('terminal_bank_account') ?>"  required="" value="{linked_bank_account_no}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="customer_care_phone_no" class="col-sm-3 col-form-label"><?php echo display('customer_care_phone_no')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_care_phone_no" id="customer_care_phone_no" type="text" placeholder="<?php echo display('customer_care_phone_no') ?>"  required="" value="{customer_care_phone_no}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="update_terminal" class="btn btn-success btn-large" name="update_terminal" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit customer end -->



