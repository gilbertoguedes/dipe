<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Block Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_block') ?></h1>
	        <small><?php echo display('manage_your_block') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_block') ?></li>
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
                
                  <a href="<?php echo base_url('Cblock')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_block')?></a>

                </div>
            </div>
        </div>

		<!-- Manage Block -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_block') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('category_name') ?></th>
										<th class="text-center"><?php echo display('block_position') ?></th>
										<th class="text-center"><?php echo display('image') ?></th>
										<th class="text-center"><?php echo display('block_style') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($block_list) {
									foreach ($block_list as $value) {
								?>
									<tr>
										<td class="text-center"><?php echo $value['sl']?></td>
										<td class="text-center"><?php echo $value['category_name']?></td>
										<td class="text-center"><?php echo $value['block_position']?></td>
										<td class="text-center"><img src="<?php echo $value['block_image']?>" height="60" width="100"></td>
										<td class="text-center"><?php echo $value['block_style']?></td>
										<td>
											<center>
												<?php
		                                            #----status change start---#
		                                            $status=$value['status'];
		                                        if ($status==1) {
		                                                ?>
                                                <a href="<?= base_url();?>Cblock/inactive/<?= $value['block_id']?>">
                                                    <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('inactive')?>"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                </a>
		                                                <?php
		                                            }else{
		                                                ?>
                                                <a href="<?= base_url();?>Cblock/active/<?= $value['block_id']?>">
                                                    <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('active')?>"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                </a>
		                                        <?php
		                                        }
		                                        #----status change end---#
		                                        ?>

												<a href="<?php echo base_url().'Cblock/block_update_form/'.$value['block_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="<?php echo base_url('Cblock/block_delete/'.$value['block_id'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
<!-- Manage Block End -->

<!-- Delete block ajax code -->
<script type="text/javascript">
	//Delete block 
	$(".delete_block").click(function()
	{	
		var block_id=$(this).attr('name');
		var csrf_test_name=  $("[name=csrf_test_name]").val();
		var x = confirm('<?php echo display('are_you_sure_want_to_delete')?>');
		if (x==true){
		$.ajax
		   ({
				type: "POST",
				url: '<?php echo base_url('Cblock/block_delete')?>',
				data: {block_id:block_id,csrf_test_name:csrf_test_name},
				cache: false,
				success: function(datas)
				{
					setTimeout("location.reload(true);",300);
	
				} 
			});
		}
	});
</script>



