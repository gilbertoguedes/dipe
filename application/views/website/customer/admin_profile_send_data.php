<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Edit Profile Page Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-user-female"></i></div>
        <div class="header-title">
            <h1><?php echo display('admin_data_send') ?></h1>
            <small><?php echo display('admin_data_send') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i><?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('profile') ?></a></li>
                <li class="active"><?php echo display('admin_data_send') ?></li>
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

                    <a href="<?php echo base_url('customer/customer_dashboard/add_profile_send_data')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i><?php echo display('add_send_data')?></a>

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
                                    <th style="width : 130px; min-width : 130px"><?php echo display('action') ?></th>
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
                                        <td>
                                            <center>
                                                <?php echo form_open()?>

                                                <a href="<?php echo base_url().'customer/customer_dashboard/edit_profile_send_data/{customer_information_send_data_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                                <a href="<?php echo base_url('customer/customer_dashboard/delete_profile_send_data/{customer_information_send_data_id}')?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>

                                                <?php echo form_close()?>
                                            </center>
                                        </td>
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