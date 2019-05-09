<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--Tax setting -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('tax_setting') ?></h1>
            <small><?php echo display('tax_setting') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('tax') ?></a></li>
                <li class="active"><?php echo display('tax_setting') ?></li>
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

        <!--Tax setting -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('tax_setting') ?> </h4>
                        </div>
                    </div>
                  <?php echo form_open_multipart('Ctax/tax_update/{t_p_s_id}',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">
                        <?php
                        if ($tax_list) {
                            $i=1;
                            foreach ($tax_list as $tax) {
                        ?>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-5">
                                <div class="form-group row">
                                    <label for="tax_name" class="col-sm-4 col-form-label"><?php echo display('tax_name_'.$i)?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="tax_name"  type="text" placeholder="<?php echo display('tax_name') ?>"  required="" id="tax_name_<?php echo $tax['tax_id']?>" value="<?php echo $tax['tax_name']?>" onblur="edit_tax_name('<?php echo $tax['tax_id'];?>')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <!-- skin-square -->
                                <div class="form-group row">
                                    <div class="i-check">
                                        <input type="checkbox" id="square-checkbox-<?php echo $i?>" <?php if ($tax['status'] == 1) {echo "checked='checked'";} ?> value="<?php echo $tax['tax_id']?>" class="taxStatus">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            $i++;
                            }
                        }
                        ?>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Tax setting end -->


<script type="text/javascript">
    function edit_tax_name(id){
        var value = $('#tax_name_'+id).val();
        //var csrf_test_name = document.forms["lang"]["csrf_test_name"].value;

        $.ajax({
            url: "<?php echo base_url()?>Ctax/update_tax",
            type: 'POST',
            data: {'id':id,'value':value}, 
            success: function (data){ 
                toastr.success(data, " ", {
                    "timeOut": "200",
                    "extendedTImeout": "200"
                });   
            },
            error: function (exc){
                toastr.warning("Failed");
            }
        });
    }



    $(".taxStatus").bind('click', function() { 
        if($(this).attr('checked'))
        {
            var tax_id = $(this).val();
            var tax_name = $('#tax_name_'+tax_id).val();
            $.post("<?php echo base_url('Ctax/inactive_tax')?>",
            {
                tax_id: tax_id,
                tax_name: tax_name
            },

            function(data, status){
                if (data == 1) {
                    toastr.success('Inactive successfully', " ", {
                        "timeOut": "200",
                        "extendedTImeout": "200"
                    });
                    location.reload();
                }
            });
        }
        else
        {
            var tax_id   = $(this).val();
            var tax_name = $('#tax_name_'+tax_id).val();
            $.post("<?php echo base_url('Ctax/active_tax')?>",
            {
                tax_id: tax_id,
                tax_name: tax_name
            },

            function(data, status){
                if (data == 1) {
                    toastr.success('Active successfully', " ", {
                        "timeOut": "200",
                        "extendedTImeout": "200"
                    });
                    location.reload();
                }
            });
        }
    });
</script>



