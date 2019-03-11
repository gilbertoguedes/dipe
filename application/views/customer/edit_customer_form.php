<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Edit customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('customer') ?></h1>
            <small><?php echo display('customer_show') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('customer') ?></a></li>
                <li class="active"><?php echo display('customer_show') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- alert message -->
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
                  <?php echo form_open_multipart('Ccustomer/customer_update',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                    	<div class="form-group row">
                            <label for="customer_name" class="col-sm-3 col-form-label"><?php echo display('name') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_name" id="customer_name" type="text" placeholder="<?php echo display('customer_name') ?>"  required="" value="{customer_name}">
                            </div>
                        </div>
   
                       	<div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="email" value="{customer_email}" id="email" type="email" placeholder="<?php echo display('customer_email') ?>"  required="">
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>

        <!-- Manage Product report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('admin_data_send') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th style="width : 150px; min-width : 150px"><?php echo display('customer_get_data') ?></th>
                                    <th><?php echo display('phone_number') ?></th>
                                    <th style="width : 200px; min-width : 200px"><?php echo display('address') ?></th>
                                    <th><?php echo display('colony') ?></th>
                                    <th><?php echo display('delegation') ?></th>
                                    <th><?php echo display('state') ?></th>
                                    <th><?php echo display('zip') ?></th>
                                    <th><?php echo display('refer') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($admin_profile_send_data_list) {
                                    ?>
                                    {admin_profile_send_data_list}
                                    <tr>
                                        <td>{customer_name}</td>
                                        <td>{customer_phone_number}</td>
                                        <td>{customer_street} Número Exterior-{customer_exter_number} Número Interior-{customer_inter_number} % {customer_between1} y {customer_between2}</td>
                                        <td>{customer_colony}</td>
                                        <td>{customer_delegation}</td>
                                        <td>{customer_state}</td>
                                        <td>{customer_zip}</td>
                                        <td>{customer_refer}</td>
                                    </tr>
                                    {/admin_profile_send_data_list}
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manage Product report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('admin_invoice_data') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample4" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th style="width : 150px; min-width : 150px"><?php echo display('variant') ?></th>
                                    <th style="width : 150px; min-width : 150px"><?php echo display('rfc') ?></th>
                                    <th style="width : 150px; min-width : 150px"><?php echo display('name') ?> / <?php echo display('social_reason') ?></th>
                                    <th style="width : 150px; min-width : 150px"><?php echo display('email') ?></th>
                                    <th style="width : 200px; min-width : 200px"><?php echo display('address') ?></th>
                                    <th><?php echo display('colony') ?></th>
                                    <th><?php echo display('delegation') ?></th>
                                    <th><?php echo display('state') ?></th>
                                    <th><?php echo display('zip') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($admin_profile_invoice_data_list) {
                                    ?>
                                    <?php foreach($admin_profile_invoice_data_list as $data) { ?>
                                        <tr>
                                            <td>
                                                <?php if($data['customer_variant']==1){ ?>
                                                    <?php echo  display('physics_person'); ?>
                                                <?php } else { ?>
                                                    <?php echo display('morale_person'); } ?>
                                            </td>
                                            <td><?php echo $data['customer_rfc']; ?></td>
                                            <td>
                                                <?php if($data['customer_variant']==1){ ?>
                                                    <?php echo $data['customer_name'].' '.$data['customer_first_lastname'].' '.$data['customer_secon_lastname'];  ?>
                                                <?php } else { ?>
                                                    <?php echo $data['customer_social_reason']; } ?>
                                            </td>
                                            <td><?php echo $data['customer_email']; ?></td>
                                            <td><?php echo $data['customer_street'].' Número Exterior - '.$data['customer_exter_number'].' Número Interior - '.$data['customer_inter_number'].' % '.$data['customer_between1'].' y '.$data['customer_between2']; ?></td>
                                            <td><?php echo $data['customer_colony']; ?></td>
                                            <td><?php echo $data['customer_delegation']; ?></td>
                                            <td><?php echo $data['customer_state']; ?></td>
                                            <td><?php echo $data['customer_zip']; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit customer end -->


<!-- //Select cities from country-->
<script type="text/javascript">
    //Product selection start
    $('body').on('change', '#country', function(){
        var country_id = $(this).val();
        $.ajax
        ({
            url: "<?php echo base_url('Ccustomer/select_city_country_id')?>",
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



