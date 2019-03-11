<!--Update email setting start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('email_configuration') ?></h1>
            <small><?php echo display('email_configuration') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li class="active"><?php echo display('email_configuration') ?></li>
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

        <!--Email setting -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('email_configuration') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Csoft_setting/update_email_configuration/{email_id}', array('class' => 'form-vertical','id' => 'insert_customer'))?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="protocol" class="col-sm-3 col-form-label"><?php echo display('protocol') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="protocol" id="protocol" type="text" value="{protocol}">
                            </div>
                            <div class="col-sm-3">
                              <p style="font-weight: 600"> smtp  </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mailtype" class="col-sm-3 col-form-label"><?php echo display('mailtype') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="mailtype" id="mailtype">
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <option value="html" <?php if ($mailtype == 'html') {echo "selected";}?>><?php echo display('html') ?></option>
                                    <option value="text" <?php if ($mailtype == 'text') {echo "selected";}?>><?php echo display('text') ?></option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                              <p style="font-weight: 600"> html  </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="smtp_host" class="col-sm-3 col-form-label"><?php echo display('smtp_host') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="smtp_host" id="smtp_host" type="text" value="{smtp_host}">
                            </div>
                            <div class="col-sm-3">
                              <p style="font-weight: 600"> OR /usr/sbin/sendmail </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="smtp_port" class="col-sm-3 col-form-label"><?php echo display('smtp_port') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="smtp_port" id="smtp_port" type="text" value="{smtp_port}">
                            </div>

                            <div class="col-sm-3">
                              <p style="font-weight: 600"> 465  </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sender_email" class="col-sm-3 col-form-label"><?php echo display('sender_email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="sender_email" id="sender_email" type="email" value="{sender_email}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="password" id="password" type="password" value="{password}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save_changes') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!--Update email setting end -->