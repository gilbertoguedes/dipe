<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit Profile Page Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-user-female"></i></div>
        <div class="header-title">
            <h1><?php echo display('update_profile') ?></h1>
            <small><?php echo display('your_profile') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i><?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('profile') ?></a></li>
                <li class="active"><?php echo display('update_profile') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12 col-md-4">
            </div>
            <div class="col-sm-12 col-md-4">

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
                <?php echo form_open_multipart('customer/customer_dashboard/update_profile',array('class' => 'form-vertical','id' => 'validate' ))?>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-menu">
                            <i class="fa fa-bars"></i>
                        </div>
                        <div class="card-header-headshot" style="background-image: url({image});"></div>
                    </div>
                    <div class="card-content">
                        <div class="card-content-member">
                            <h4 class="m-t-0">{first_name} {last_name}</h4>
                        </div>
                        <div class="card-content-languages">
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('first_name') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <input type="text" placeholder="<?php echo display('first_name') ?>" class="form-control" id="first_name" name="first_name" value="{first_name}" required />
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('last_name') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="text" placeholder="<?php echo display('last_name') ?>" class="form-control" id="last_name" name="last_name" value="{last_name}" required  /></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('email') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="email" placeholder="<?php echo display('email') ?>" class="form-control" id="email" name="email" value="{email}" required /></li>
                                    </ul>
                                </div>
                            </div>   
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('mobile') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="number" placeholder="<?php echo display('mobile') ?>" class="form-control" id="mobile" name="customer_mobile" value="{customer_mobile}" required /></li>
                                    </ul>
                                </div>
                            </div> 
                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('address') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="text" placeholder="<?php echo display('address') ?>" class="form-control" id="customer_short_address" name="customer_short_address" value="{customer_short_address}" required /></li>
                                    </ul>
                                </div>
                            </div>                         

                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('customer_address_1') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="text" placeholder="<?php echo display('customer_address_1') ?>" class="form-control" id="customer_address_1" name="customer_address_1" value="{customer_address_1}" required /></li>
                                    </ul>
                                </div>
                            </div>                            

                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('customer_address_2') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="text" placeholder="<?php echo display('customer_address_2') ?>" class="form-control" id="customer_address_2" name="customer_address_2" value="{customer_address_2}" required /></li>
                                    </ul>
                                </div>
                            </div>                            

                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('city') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="text" placeholder="<?php echo display('city') ?>" class="form-control" id="city" name="city" value="{city}" required /></li>
                                    </ul>
                                </div>
                            </div>   

                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('country') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li>
                                            <select class="form-control select2" id="country" name="country" style="width: 180px">
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
                                        </li>
                                    </ul>
                                </div>
                            </div>                           

                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('state') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li>
                                            <select class="form-control select2" id="state" name="state" style="width: 180px">
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
                                        </li>
                                    </ul>
                                </div>
                            </div>
                                                  

                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('zip') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="text" placeholder="<?php echo display('zip') ?>" class="form-control" id="zip" name="zip" value="{zip}" required /></li>
                                    </ul>
                                </div>
                            </div>                                                       

                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('company') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="text" placeholder="<?php echo display('company') ?>" class="form-control" id="company" name="company" value="{company}" required /></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content-languages-group">
                                <div>
                                    <h4><?php echo display('image') ?>:</h4>
                                </div>
                                <div>
                                    <ul>
                                        <li><input type="file" id="image" name="image" value="{image}" /></li>
                                        <input type="hidden" name="old_image" value="{image}" />
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="card-footer-stats">
                          <button type="submit" class="btn btn-success" style="margin-left: 90px;"><?php echo display('update_profile') ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close()?>
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