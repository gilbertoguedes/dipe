<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Brand Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_terminal') ?></h1>
	        <small><?php echo display('manage_your_terminal') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('terminal') ?></a></li>
	            <li class="active"><?php echo display('manage_terminal') ?></li>
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


        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                
                  <a href="<?php echo base_url('Cterminal')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_terminal')?></a>

                </div>
            </div>
        </div>

		<!-- Manage Brand -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_terminal') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('terminal_name') ?></th>
										<th class="text-center"><?php echo display('terminal_company') ?></th>
										<th class="text-center"><?php echo display('terminal_bank_account') ?></th>
										<th class="text-center"><?php echo display('customer_care_phone_no') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
									if ($terminal_list) {
								?>
								{terminal_list}
									<tr>
										<td class="text-center">{sl}</td>
										<td class="text-center">{terminal_name}</td>
										<td class="text-center">{terminal_provider_company}</td>
										<td class="text-center">{linked_bank_account_no}</td>
										<td class="text-center">{customer_care_phone_no}</td>
										<td>
											<center>
											<?php echo form_open()?>
												<a href="<?php echo base_url().'Cterminal/terminal_update_form/{pay_terminal_id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="<?php echo base_url('Cterminal/terminal_delete/{pay_terminal_id}')?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php echo form_close()?>
											</center>
										</td>
									</tr>
								{/terminal_list}
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
<!-- Manage Brand End -->

<!-- Delete Brand ajax code -->
<script type="text/javascript">
	//Delete Brand 
	$(".delete_terminal").click(function()
	{	
		var pay_terminal_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm('<?php echo display('are_you_sure_want_to_delete')?>');
		if (x==true){
		$.ajax({
				type: "POST",
				url: '<?php echo base_url('Cterminal/terminal_delete')?>',
				data: {pay_terminal_id:pay_terminal_id,csrf_test_name:csrf_test_name},
				cache: false,
				success: function(datas)
				{
					setTimeout("location.reload(true);",300);
	
				} 
			});
		}
	});
</script>



