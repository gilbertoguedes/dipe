<!--Update email setting start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('payment_gateway_setting') ?></h1>
            <small><?php echo display('payment_gateway_setting') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li class="active"><?php echo display('payment_gateway_setting') ?></li>
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
        <!--Payment setting -->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 m-b-20">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <?php
                    if ($setting_detail) {
                        $i=1;
                        foreach ($setting_detail as $setting) {
                    ?>
                    <li class="<?php if($i == 1){echo "active";}?>"><a href="#tab<?php echo $i?>" data-toggle="tab" aria-expanded="true"><?php echo $setting['agent']?></a></li>
                    <?php
                        $i++;
                        }
                    }
                    ?>
                </ul>
                <!-- Tab panels -->
                <div class="tab-content">
                <?php
                if ($setting_detail) {
                    $i=1;
                    foreach ($setting_detail as $setting) {
                ?>
                    <div class="tab-pane fade <?php if($i == 1){echo "active in";}?>" id="tab<?php echo $i?>">
                        <div class="panel-body">
                            <?php
                            if ($setting['id'] == 2) {
                            ?>
                            <form action="<?php echo base_url('Csoft_setting/update_payment_gateway_setting/'.$setting['id'])?>" class="form-vertical" id="validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <div class="form-group row">
                                    <label for="shop_id" class="col-sm-3 col-form-label"><?php echo display('shop_id')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="shop_id" id="shop_id" type="text" value="<?php echo $setting['shop_id']?>">
                                    </div>

                                    <div class="col-sm-2">
                                       <a href="https://payeer.com/en/account/?register=yes" target="_blank"><?php echo display('create_account')?></a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="secret_key" class="col-sm-3 col-form-label"><?php echo display('secret_key')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="secret_key" id="secret_key" type="text" value="<?php echo $setting['secret_key']?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="status" id="status" required="" aria-hidden="true" aria-required="true" style="width: 100%">
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['status']==1){echo "selected";}?>><?php echo display('active')?></option>
                                            <option value="2" <?php if($setting['status']==2){echo "selected";}?>><?php echo display('inactive')?></option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submit" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-6">
                                       <input type="submit" class="btn btn-success btn-large" value="<?php echo display('save_changes')?>">
                                    </div>
                                </div>
                            </form>
                            <?php
                            }else if ($setting['id'] == 1){
                            ?>
                            <form action="<?php echo base_url('Csoft_setting/update_payment_gateway_setting/'.$setting['id'])?>" class="form-vertical" id="validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <div class="form-group row">
                                    <label for="public_key" class="col-sm-3 col-form-label"><?php echo display('public_key')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="public_key" id="public_key" type="text" value="<?php echo $setting['public_key']?>">
                                    </div>

                                    <div class="col-sm-2">
                                       <a href="https://gourl.io/view/registration" target="_blank"><?php echo display('create_account')?></a>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="private_key" class="col-sm-3 col-form-label"><?php echo display('private_key')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="private_key" id="private_key" type="text" value="<?php echo $setting['private_key']?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="status" id="status" required="" aria-hidden="true" aria-required="true" style="width: 100%">
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['status']==1){echo "selected";}?>><?php echo display('active')?></option>
                                            <option value="2" <?php if($setting['status']==2){echo "selected";}?>><?php echo display('inactive')?></option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submit" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-6">
                                       <input type="submit" class="btn btn-success btn-large" value="<?php echo display('save_changes')?>">
                                    </div>
                                </div>
                            </form>
                            <?php 
                            } else if ($setting['id'] == 3){
                            ?>
                            <form action="<?php echo base_url('Csoft_setting/update_payment_gateway_setting/'.$setting['id'])?>" class="form-vertical" id="validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <div class="form-group row">
                                    <label for="paypal_email" class="col-sm-3 col-form-label"><?php echo display('paypal_email')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="paypal_email" id="paypal_email" type="email" value="<?php echo $setting['paypal_email']?>">
                                    </div>
                                    <div class="col-sm-2">
                                       <a href="https://www.paypal.com/us/home" target="_blank"><?php echo display('create_account')?></a>
                                    </div>
                                </div>              

                                <div class="form-group row">
                                    <label for="client_id" class="col-sm-3 col-form-label"><?php echo display('client_id')?></label>
                                    <div class="col-sm-6">
                                        <input class="form-control" name="client_id" id="client_id" type="text" value="<?php echo $setting['paypal_client_id']?>" placeholder="<?php echo display('client_id')?>">
                                        <small class="text-muted"><?php echo display('optional')?></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="currency" class="col-sm-3 col-form-label"><?php echo display('currency')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="currency" id="currency" required="" aria-hidden="true" aria-required="true" style="width: 100%">
                                            <option value=""></option>
                                            <?php
                                            if ($currency_list) {
                                                foreach ($currency_list as $k => $currency) {
                                            ?>
                                            <option value="<?php echo $k?>" <?php if($setting['currency']== $k){echo "selected";}?>><?php echo $currency?></option>
                                            <?php } }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label"><?php echo display('status')?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="status" id="status" required="" aria-hidden="true" aria-required="true" style="width: 100%">
                                            <option value=""></option>
                                            <option value="1" <?php if($setting['status']==1){echo "selected";}?>><?php echo display('active')?></option>
                                            <option value="2" <?php if($setting['status']==2){echo "selected";}?>><?php echo display('inactive')?></option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="submit" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-6">
                                       <input type="submit" class="btn btn-success btn-large" value="<?php echo display('save_changes')?>">
                                    </div>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                    $i++;
                    }
                }
                ?>
                </div>
            </div>
        </div>
    </section>
</div>
<!--Update email setting end -->