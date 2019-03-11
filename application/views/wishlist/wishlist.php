<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Wishlist Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_wishlist') ?></h1>
	        <small><?php echo display('manage_your_wishlist') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_wishlist') ?></li>
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
                
                  <a href="<?php echo base_url('Cwishlist')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_wishlist')?></a>

                </div>
            </div>
        </div>

		<!-- Manage Wishlist -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_wishlist') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('product_name') ?></th>
										<th class="text-center"><?php echo display('user') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($wishlist_list) {
									foreach ($wishlist_list as $wishlist) {
								?>
									<tr>
										<td class="text-center"><?php echo $wishlist['sl']?></td>
										<td class="text-center"><?php echo $wishlist['product_name'].' - ('.$wishlist['product_model'].')'?></td>
										<td class="text-center"><?php echo $wishlist['first_name'].' '.$wishlist['last_name']?></td>
										<td>
											<center>
											<?php
		                                    $status=$wishlist['status'];
		                                    if ($status==1) {
		                                    ?>
                                                <a href="<?= base_url();?>Cwishlist/inactive/<?= $wishlist['wishlist_id']?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo display('inactive')?>"><i class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <?php
                                            }else{
                                                ?>
                                                <a href="<?= base_url();?>Cwishlist/active/<?= $wishlist['wishlist_id']?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('active')?>"><i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
	                                        <?php
	                                        }
	                                        ?>
												<a href="<?php echo base_url().'Cwishlist/wishlist_update_form/'.$wishlist['wishlist_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="<?php echo base_url('Cwishlist/wishlist_delete/'.$wishlist['wishlist_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');"  data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
											</center>
										</td>
									</tr>
								<?php
									}
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
<!-- Manage Wishlist End -->

<!-- Delete wishlist ajax code -->
<script type="text/javascript">
	//Delete wishlist 
	$(".delete_wishlist").click(function()
	{	
		var wishlist_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm('<?php echo display('are_you_sure_want_to_delete')?>');
		if (x==true){
		$.ajax
		   ({
				type: "POST",
				url: '<?php echo base_url('Cwishlist/wishlist_delete')?>',
				data: {wishlist_id:wishlist_id,csrf_test_name:csrf_test_name},
				cache: false,
				success: function(datas)
				{
					setTimeout("location.reload(true);",100);
	
				} 
			});
		}
	});
</script>



