<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit Profile Page Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-user-female"></i></div>
        <div class="header-title">
            <h1><?php echo display('update_general_profile_data') ?></h1>
            <small><?php echo display('general_data') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i><?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('profile') ?></a></li>
                <li class="active"><?php echo display('general_data') ?></li>
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('general_data') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('customer/customer_dashboard/update_profile',array('class' => 'form-vertical','id' => 'validate' ))?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('first_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('first_name') ?>" class="form-control" id="first_name" name="first_name" value="{first_name}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('last_name')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('last_name') ?>" class="form-control" id="last_name" name="last_name" value="{last_name}" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('email')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="<?php echo display('email') ?>" class="form-control" id="email" name="email" value="{email}" required />
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
                            <label for="category_name" class="col-sm-4 col-form-label"><?php echo display('image')?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input type="file" id="image" name="image" value="{image}" />
                                <input type="hidden" name="old_image" value="{image}" />
                            </div>
                        </div>
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
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Edit Profile Page End -->

<!-- //Select cities from country-->
<script type="text/javascript">
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