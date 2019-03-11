<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- About us Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('manage_about_us') ?></h1>
	        <small><?php echo display('manage_your_about_us') ?></small>
	        <ol class="breadcrumb">
	            <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('web_settings') ?></a></li>
	            <li class="active"><?php echo display('manage_about_us') ?></li>
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
                
                  <a href="<?php echo base_url('Cabout_us')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_about_us')?></a>

                </div>
            </div>
        </div>

		<!-- About us -->
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('manage_about_us') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
		                <div class="table-responsive">
		                    <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th class="text-center"><?php echo display('sl') ?></th>
										<th class="text-center"><?php echo display('favicon') ?></th>
										<th class="text-center"><?php echo display('language') ?></th>
										<th class="text-center"><?php echo display('headlines') ?></th>
										<th class="text-center"><?php echo display('details') ?></th>
										<th class="text-center"><?php echo display('position') ?></th>
										<th class="text-center"><?php echo display('action') ?></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($about_us_list) {
									foreach ($about_us_list as $about_us) {
								?>
									<tr>
										<td class="text-center"><?php echo $about_us['sl']?></td>
										<td class="text-center"><?php echo $about_us['icon']?></td>
										<td class="text-center"><?php echo $about_us['language_id']?></td>
										<td class="text-center"><?php echo $about_us['headline']?></td>
										<td class="text-center" width="280"><?php echo character_limiter($about_us['details'], 50);?></td>
										<td class="text-center"><?php echo $about_us['position']?></td>
										<td>
											<center>
											<?php
		                                    $status=$about_us['status'];
		                                    if ($status==1) {
		                                    ?>
                                                <a href="<?= base_url();?>Cabout_us/inactive/<?= $about_us['content_id']?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo display('inactive')?>"><i class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <?php
                                            }else{
                                                ?>
                                                <a href="<?= base_url();?>Cabout_us/active/<?= $about_us['content_id']?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo display('active')?>"><i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
	                                        <?php
	                                        }
	                                        ?>
												<a href="<?php echo base_url().'Cabout_us/about_us_update_form/'.$about_us['position']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>

												<a href="<?php echo base_url('Cabout_us/about_us_delete/'.$about_us['position'])?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo display('are_you_sure_want_to_delete')?>');" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
<!-- About us End -->



