<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage store Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_store_product') ?></h1>
	        <small><?php echo display('manage_your_store_product') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('store_set') ?></a></li>
	            <li class="active"><?php echo display('manage_store_product') ?></li>
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
                
                  	<a href="<?php echo base_url('Cstore')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_store')?></a>
                  	<a href="<?php echo base_url('Cstore/manage_store')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_store')?></a>
                  	<a href="<?php echo base_url('Cstore/store_transfer')?>" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('store_transfer')?></a>

                </div>
            </div>
        </div>

		<!-- Manage store -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_store_product') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('store_name') ?></th>
										<th class="text-center"><?php echo display('product_name') ?></th>
										<th class="text-center"><?php echo display('variant') ?></th>
										<th class="text-center"><?php echo display('quantity') ?></th>
										<!-- <th class="text-center"><?php echo display('action') ?></th> -->
									</tr>
								</thead>
								<tbody>
								<?php
								if ($store_product_list) {
								?>
								{store_product_list}
									<tr>
										<td class="text-center">{sl}</td>
										<td class="text-center">{store_name}</td>
										<td class="text-center"><a href="<?php echo base_url('Cproduct/product_details/{product_id}')?>">
										{product_name}-({product_model})</a></td>
										<td class="text-center">{variant_name}</td>
										<td class="text-center">{quantity}</td>
								<!-- 		<td>
											<center>
											<?php echo form_open()?>
												<a href="" class="delete_store_product btn btn-danger btn-sm" name="{store_id}" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											<?php echo form_close()?>
											</center>
										</td> -->
									</tr>
								{/store_product_list}
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
<!-- Manage store End -->

<!-- Delete store ajax code -->
<script type="text/javascript">
	//Delete store 
	$(".delete_store_product").click(function()
	{	
		var store_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm('<?php echo display('are_you_sure_want_to_delete')?>');
		if (x==true){
		$.ajax
		   ({
				type: "POST",
				url: '<?php echo base_url('Cstore/store_product_delete')?>',
				data: {store_id:store_id,csrf_test_name:csrf_test_name},
				cache: false,
				success: function(datas)
				{
					setTimeout("location.reload(true);",300);
	
				} 
			});
		}
	});
</script>



