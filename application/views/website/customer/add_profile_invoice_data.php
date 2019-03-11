<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit Profile Page Start -->
<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-user-female"></i></div>
        <div class="header-title">
            <h1><?php echo display('add_data_invoice') ?></h1>
            <small><?php echo display('add_data_invoice') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i><?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('profile') ?></a></li>
                <li class="active"><?php echo display('add_data_invoice') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
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

                    <a href="<?php echo base_url('customer/customer_dashboard/admin_profile_invoice_data')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i><?php echo display('admin_invoice_data')?></a>

                </div>
            </div>
        </div>


        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('invoice_data') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('customer/customer_dashboard/insert_invoice_data',array('class' => 'form-vertical','id' => 'validate' ))?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label"><?php echo display('kind_of_person');?> <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <select class="form-control" name="customer_variant" id="customer_variant" required>
                                    <option value=""><?php echo display('physical').' / '.display('morale'); ?></option>
                                    <option value="1"><?php echo display('physics_person')?></option>
                                    <option value="2"><?php echo display('morale_person')?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label"><?php echo display('rfc')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <input type="text" placeholder="<?php echo display('rfc') ?>" class="form-control" id="customer_rfc" name="customer_rfc" required />
                            </div>
                        </div>
                        <div id="customer_social_reason" class="form-group row">
                            <label  class="col-sm-3 col-form-label"><?php echo display('social_reason')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <textarea  class="form-control" id="customer_social_reason" name="customer_social_reason" required /></textarea>
                            </div>
                        </div>
                        <div id="customer_name" class="form-group row">
                            <label  class="col-sm-3 col-form-label"><?php echo display('name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-5">
                                <input type="text" placeholder="<?php echo display('name') ?>" class="form-control" id="customer_name" name="customer_name" required />
                            </div>
                        </div>
                        <div id="customer_last_name" class="form-group row">
                            <label  class="col-sm-3 col-form-label"><?php echo display('customer_first_lastname')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="<?php echo display('customer_first_lastname') ?>" class="form-control" id="customer_first_lastname"  name="customer_first_lastname" required />
                            </div>
                            <label  class="col-sm-3 col-form-label"><?php echo display('customer_secon_lastname')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="<?php echo display('customer_secon_lastname') ?>" class="form-control" id="customer_secon_lastname"  name="customer_secon_lastname" required />
                            </div>
                        </div>
                        <!--<div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('mobile')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('mobile') ?>" class="form-control" id="mobile" name="customer_mobile" value="{customer_mobile}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('address')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('address') ?>" class="form-control" id="customer_short_address" name="customer_short_address" value="{customer_short_address}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('customer_address_1')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('customer_address_1') ?>" class="form-control" id="customer_address_1" name="customer_address_1" value="{customer_address_1}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('customer_address_2')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('customer_address_2') ?>" class="form-control" id="customer_address_2" name="customer_address_2" value="{customer_address_2}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('city')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('city') ?>" class="form-control" id="city" name="city" value="{city}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('country')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="country" name="country" required>
                                    <option value=""> <?php echo ""; ?> </option>
                                    <?php
                                    if ($country_list) {
                                        foreach ($country_list as $country) {
                                            ?>
                                            <option value="<?php echo $country['id']?>" <?php if ($country['id'] == $country_id) {echo "selected";}?>><?php echo $country['name']?></option>
                                        <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('state')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="state" name="state" required>
                                    <option value=""><?php echo display('select_one') ?></option>
                                    <?php
                                    if ($state_list) {
                                        foreach ($state_list as $state) {
                                            ?>
                                            <option value="<?php echo $state->name?>" <?php if ($state->name == $state_name) {echo "selected";}?>><?php echo $state->name?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('zip')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('zip') ?>" class="form-control" id="zip" name="zip" value="{zip}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('company')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('company') ?>" class="form-control" id="company" name="company" value="{company}" required />
                            </div>
                        </div>-->
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-6 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="add-customer" class="btn btn-success btn-large" name="add-customer" value="<?php echo display('save') ?>" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Edit Profile Page End -->

<!-- //Select cities from country-->
<script type="text/javascript">

    $('#customer_social_reason').css({'display': 'none'});
    $('#customer_name').css({'display': 'none'});
    $('#customer_last_name').css({'display': 'none'});

    $('#customer_variant').on('change', function() {
        var customer_variant = $('#customer_variant option:selected').val();
        if (customer_variant == 1) {
            $('#customer_name').css({'display': 'block'});
            $('#customer_last_name').css({'display': 'block'});
            $('#customer_social_reason').css({'display': 'none'});
        }else if (customer_variant == 2){
            $('#customer_name').css({'display': 'none'});
            $('#customer_last_name').css({'display': 'none'});
            $('#customer_social_reason').css({'display': 'block'});
        }
        else
        {
            $('#customer_name').css({'display': 'none'});
            $('#customer_last_name').css({'display': 'none'});
            $('#customer_social_reason').css({'display': 'none'});
        }
    });

    //Product selection start
    $('body').on('change', '#country', function(){
        var country_id = $(this).val();
        $.ajax
        ({
            url: "<?php echo base_url('website/customer/Customer_dashboard/select_city_country_id')?>",
            data: {country_id:country_id},
            type: "post",
            success: function(data)
            {
                $('#state').html(data);   
            } 
        });
    });
    //Product selection end
</script>