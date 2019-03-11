<?php defined('BASEPATH') OR exit('No direct script access allowed');
if ($this->cart->contents()) { ?>
<!-- ========== CheckOut Area -->
<section class="checkout">
    <div class="container">

        <!-- Alert Message -->
        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>          
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php echo $message ?>   
        </div>  
        <?php 
            $this->session->unset_userdata('message');
            }
            $error_message = $this->session->userdata('error_message');
            if (isset($error_message)) {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
           <?php echo $error_message ?>  
        </div>
        <?php 
            $this->session->unset_userdata('error_message');
            }
        ?>
        <form action="<?php echo base_url('submit_checkout')?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" >

            <!-- SmartWizard html -->
            <div id="wizard_form">
                <ul>
                    <?php if (! $this->user_auth->is_logged()) { ?>
                    <!--<li><a href="#step-1"><?php echo display('checkout_options')?></a></li>-->
                    <?php } ?>
                    <li><a href="#step-1"><?php echo display('billing_details')?></a></li>
                    <li><a href="#step-2"><?php echo display('delivery_details')?></a></li>
                    <!--<li><a href="#step-3"><?php echo display('delivery_method')?></a></li>-->
                    <li><a href="#step-3"><?php echo display('payment_method')?></a></li>
                    <li><a href="#step-4"><?php echo display('confirm_order')?></a></li>
                </ul>

                <div class="wizard_inner">
                    <!--<div id="step-1">
                        <div id="form-step-0" role="form" data-toggle="validator" class="step1_inner">
                            <h2 class="new_user"><?php echo display('new_customer')?></h2>
                            <p><?php echo display('checkout_options')?>:</p>
                            <div class="form-group">
                                <div class="">
                                    <label>         
                                        <input type="radio" name="account" value="1" <?php if ($this->session->userdata('account_info') == 1) { echo "checked";}?> onclick="account_type()"> <?php echo display('register_account')?>
                                    </label>
                                </div>
                                <div class="">
                                    <label>     
                                        <input type="radio" name="account" value="2" <?php if ($this->session->userdata('account_info') == 2) { echo "checked";}?> onclick="account_type()"> <?php echo display('guest_checkout')?>
                                    </label>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>

                            <p class="div_ender"><?php echo display('by_creating_an_account_you_will_able_to_shop_faster')?></p>
                            <h2 class="old_user"><?php echo display('returning_customer')?></h2>

                            <div class="form-group">
                                <label for="login_email"><?php echo display('email')?>:</label>
                                <input type="email" class="form-control" name="email" id="login_email" placeholder="<?php echo display('email')?>">
                            </div>

                            <div class="form-group">
                                <label for="password"><?php echo display('password')?>:</label>
                                <input type="password" class="form-control" name="password" id="login_password" placeholder="<?php echo display('password')?>">
                            </div>

                            <div class="form-group">
                                <label for="password"></label>
                                <button type="button" class="btn btn-success customer_login"><?php echo display('login')?></button>
                            </div>

                        </div>
                    </div>-->

                    <!-- Customer login by ajax start-->
                    <script type="text/javascript">
                        //Retrive district
                        /*$('body').on('click', '.customer_login', function() {
                            var login_email    = $('#login_email').val();
                            var login_password = $('#login_password').val();

                            if (login_email == 0 || login_password == 0) {
                                alert('Please type email and password.');
                                return false;
                            }
                            $.ajax({
                                type: "post",
                                async: true,
                                url: '<?php echo base_url('website/customer/Login/checkout_login')?>',
                                data: {login_email:login_email,login_password:login_password},
                                success: function(data) {
                                    if (data == 'true') {
                                        location.reload();
                                        $('#wizard_form').smartWizard('next');
                                    }else{
                                        location.reload();
                                    }
                                },
                                error: function() {
                                    alert('Request Failed, Please check your code and try again!');
                                }
                            });
                        }); */
                    </script>
                    <!-- Customer login by ajax start-->

                    <div id="step-1">
                        <div id="form-step-0" role="form" data-toggle="validator" class="row step1_inner">
							<div class="form-group col-sm-12">
								<h4>Seleccione un perfil de facturación o llene el formulario de datos de forma manual.</h4>
								<table id="invoices" class="display" style="width:100%">
									<thead>
										<tr>
											<th style="width : 130px; min-width : 130px"><?php echo display('action') ?></th>
											<th style="display:none;"><?php echo display('variant_id') ?></th>
											<th style="width : 150px; min-width : 150px"><?php echo display('variant') ?></th>
											<th style="width : 150px; min-width : 150px"><?php echo display('rfc') ?></th>
											<th style="width : 150px; min-width : 150px"><?php echo display('name') ?> / <?php echo display('social_reason') ?></th>
											<th style="width : 150px; min-width : 150px"><?php echo display('email') ?></th>
											<th style="width : 200px; min-width : 200px"><?php echo display('address') ?></th>
											<th><?php echo display('colony') ?></th>
											<th><?php echo display('delegation') ?></th>
											<th><?php echo display('state') ?></th>
											<th><?php echo display('zip') ?></th>
											<th style="display:none;"><?php echo display('customer_first_lastname') ?></th>
											<th style="display:none;"><?php echo display('customer_secon_lastname') ?></th>
											<th style="display:none;"><?php echo display('customer_inter_number') ?></th>
											<th style="display:none;"><?php echo display('customer_exter_number') ?></th>
											<th style="display:none;"><?php echo display('customer_name') ?></th>
											<th style="display:none;"><?php echo display('customer_social_reason') ?></th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($admin_profile_invoice_data_list) {
											?>
											<?php foreach($admin_profile_invoice_data_list as $data) { ?>
											<tr>
												<td>
													<center>
														<button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('select') ?>"><i class="fa fa-check-square-o" aria-hidden="true"></i></button>
													</center>
												</td>
												<td style="display:none;">
												<?php echo $data['customer_variant']; ?>
												</td>
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
												<td><?php echo $data['customer_street'].' Número Exterior - '.$data['customer_exter_number'].' Número Interior - '.$data['customer_inter_number']; ?></td>
												<td><?php echo $data['customer_colony']; ?></td>
												<td><?php echo $data['customer_delegation']; ?></td>
												<td><?php echo $data['customer_state']; ?></td>
												<td><?php echo $data['customer_zip']; ?></td>
												<td style="display:none;"><?php echo $data['customer_first_lastname'];  ?></td>
												<td style="display:none;"><?php echo $data['customer_secon_lastname'];  ?></td>
												<td style="display:none;"><?php echo $data['customer_inter_number'];  ?></td>
												<td style="display:none;"><?php echo $data['customer_exter_number'];  ?></td>
												<td style="display:none;"><?php echo $data['customer_name'];  ?></td>
												<td style="display:none;"><?php echo $data['customer_social_reason'];  ?></td>
											</tr>
											<?php } ?>
										<?php
										}
									?>
									</tbody>
								</table>
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('customer_get_data'); echo ", "; echo display('variant')?> <i class="text-danger">*</i></label>
								<select class="form-control" name="customer_variant" id="customer_variant" required>
									<option value=""></option>
									<option value="1"><?php echo display('physics_person')?></option>
									<option value="2"><?php echo display('morale_person')?></option>
								</select>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('customer_get_data'); echo ", "; echo display('rfc')?> <i class="text-danger">*</i></label>
								<input type="text" placeholder="<?php echo display('rfc') ?>" class="form-control" id="customer_rfc" name="customer_rfc" required />
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('customer_get_data'); echo ", "; echo display('email')?> <i class="text-danger">*</i></label>
								<input type="email" placeholder="<?php echo display('email') ?>" class="form-control" id="customer_email" name="customer_email" value="<?php echo $this->session->userdata('customer_email')?>" required />
								<div class="help-block with-errors"></div>
							</div>
							<div id="group_customer_social_reason" class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('customer_get_data'); echo ", "; echo display('social_reason')?> <i class="text-danger">*</i></label>
								<textarea  class="form-control" id="customer_social_reason" name="customer_social_reason" /></textarea>
								<div class="help-block with-errors"></div>
							</div>
							<div id="group_customer_name" class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('customer_get_data'); echo ", "; echo display('name')?> <i class="text-danger">*</i></label>
								<input type="text" placeholder="<?php echo display('name') ?>" class="form-control" id="customer_name" name="customer_name"  />
								<div class="help-block with-errors"></div>
							</div>
							<div id="group_customer_first_lastname" class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('customer_get_data'); echo ", "; echo display('customer_first_lastname')?> </label>
								<input type="text" placeholder="<?php echo display('customer_first_lastname') ?>" class="form-control" id="customer_first_lastname" name="customer_first_lastname"/>
							</div>
							<div id="group_customer_secon_lastname" class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('customer_get_data'); echo ", "; echo display('customer_secon_lastname')?> </label>
								<input type="text" placeholder="<?php echo display('customer_secon_lastname') ?>" class="form-control" id="customer_secon_lastname" name="customer_secon_lastname"/>
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('address'); echo ", "; echo display('street')?> <!--<i class="text-danger">*</i>--></label>
								<input type="text" placeholder="<?php echo display('street') ?>" class="form-control" id="customer_street" name="customer_street" />
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('address'); echo ", "; echo display('inter_number')?> <!--<i class="text-danger">*</i>--></label>
								<input type="text" placeholder="<?php echo display('inter_number') ?>" class="form-control" id="customer_inter_number" name="customer_inter_number" />
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('address'); echo ", "; echo display('exter_number')?> <!--<i class="text-danger">*</i>--></label>
								<input type="text" placeholder="<?php echo display('exter_number') ?>" class="form-control" id="customer_exter_number" name="customer_exter_number" />
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('colony')?> <!--<i class="text-danger">*</i>--></label>
								<input type="text" placeholder="<?php echo display('colony') ?>" class="form-control" id="customer_colony" name="customer_colony" />
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('delegation'); echo " / "; echo display('municipality'); ?></label>
								<input type="text" placeholder="<?php echo display('delegation'); echo " / "; echo display('municipality'); ?>" class="form-control" id="customer_delegation" name="customer_delegation" />
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('state')?> <!--<i class="text-danger">*</i>--></label>
								<input type="text" placeholder="<?php echo display('state') ?>" class="form-control" id="customer_state" name="customer_state" />
							</div>
							<div class="form-group col-sm-6">
								<label  class="control_label"><?php echo display('zip')?> <!--<i class="text-danger">*</i>--></label>
								<input type="text" placeholder="<?php echo display('zip') ?>" class="form-control" id="customer_zip" name="customer_zip" />
							</div>
                        </div>
                    </div>
                
                    <div id="step-2">
                        <h2><?php echo display('delivery_details')?></h2>
                        <div id="form-step-1" role="form" data-toggle="validator" class="row step1_inner">
                            <div class="form-group col-sm-6">
                                <label for="ship_first_name" class="control-label"><?php echo display('first_name')?> * :</label>
                                <input type="text" name="ship_first_name" id="ship_first_name" placeholder="<?php echo display('first_name')?>" class="form-control" required value="<?php echo $this->session->userdata('ship_first_name')?>">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ship_last_name" class="control-label"><?php echo display('last_name')?> * :</label>
                                <input type="text" name="ship_last_name" id="ship_last_name" placeholder="<?php echo display('last_name')?>" class="form-control" required value="<?php echo $this->session->userdata('ship_last_name')?>">
                            </div>   
                            <div class="form-group col-sm-6">
                                <label for="ship_mobile" class="control-label"><?php echo display('mobile')?> * :</label>
                                <input type="text" name="ship_mobile" id="ship_mobile" placeholder="<?php echo display('mobile')?>" class="form-control" required value="<?php echo $this->session->userdata('ship_mobile')?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ship_company" class="control-label"><?php echo display('company')?> :</label>
                                <input type="text" name="ship_company" id="ship_company" placeholder="<?php echo display('company')?>" class="form-control" value="<?php echo $this->session->userdata('ship_company')?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ship_address_1" class="control-label"><?php echo display('customer_address_1')?> * :</label>
                                <input type="text" name="ship_address_1" id="ship_address_1" placeholder="<?php echo display('customer_address_1')?>" class="form-control" required value="<?php echo $this->session->userdata('ship_address_1')?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ship_address_2" class="control-label"><?php echo display('customer_address_2')?> :</label>
                                <input type="text" name="ship_address_2" id="ship_address_2" placeholder="<?php echo display('customer_address_2')?>" class="form-control" value="<?php echo $this->session->userdata('ship_address_2')?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ship_city" class="control-label"><?php echo display('city')?> :</label>
                                <input type="text" name="ship_city" id="ship_city" class="form-control" placeholder="<?php echo display('city')?>" required value="<?php echo $this->session->userdata('ship_city')?>">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ship_zip" class="control-label"><?php echo display('zip')?> * :</label>
                                <input type="text" name="ship_zip" id="ship_zip" placeholder="<?php echo display('zip')?>" class="form-control" required value="<?php echo $this->session->userdata('ship_zip')?>">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="ship_country" class="control-label"><?php echo display('country')?> * : </label>
                                <select name="ship_country" id="ship_country" class="form-control">
                                    <option value=""> --- <?php echo display('select_country')?> --- </option>
                                    <?php
                                    if ($selected_country_info) {
                                        foreach ($selected_country_info as $country) {
                                    ?>
                                    <option value="<?php echo $country->id?>" <?php if ($this->session->userdata('ship_country') == $country->id) {echo "selected";}?>><?php echo $country->name?> </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="ship_state"><?php echo display('state')?> * :</label>
                                <select name="ship_state" id="ship_state" class="form-control">
                                   <option value=""> --- <?php echo display('state')?> --- </option>
                                   <?php
                                    if ($ship_state_list) {
                                        foreach ($ship_state_list as $ship_state) {
                                    ?>
                                    <option value="<?php echo $ship_state->name?>" <?php if ($this->session->userdata('ship_state') == $ship_state->name) { echo "selected";} ?>><?php echo $ship_state->name?> </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
             
                    <!--<div id="step-3">
                        <div id="form-step-2" role="form" data-toggle="validator" class="step3_inner">
                            <p><?php echo display('kindly_select_the_preferred_shipping_method_to_use_on_this_order')?></p>
                            <?php
                            if ($select_shipping_method) {
                                foreach ($select_shipping_method as $shipping_method) {
                            ?>
                            <p><strong><?php echo $shipping_method->method_name?></strong></p>
                            <div class="radio">
                                <label>         
                                   <input type="radio" class="shipping_cost" name="shipping_cost"
                                   id="<?php echo $shipping_method->method_id?>" value="<?php echo $shipping_method->charge_amount?>" alt="<?php echo $shipping_method->details?>" <?php if ($this->session->userdata('method_id') == $shipping_method->method_id){echo "checked";} ?>>
                                    <?php
                                        $default_currency_id =  $this->session->userdata('currency_id');
                                        $currency_new_id     =  $this->session->userdata('currency_new_id');

                                        if (empty($currency_new_id)) {
                                            $result  =  $cur_info = $this->db->select('*')
                                                                ->from('currency_info')
                                                                ->where('default_status','1')
                                                                ->get()
                                                                ->row();
                                            $currency_new_id = $result->currency_id;
                                        }

                                        if (!empty($currency_new_id)) {
                                            $cur_info = $this->db->select('*')
                                                                ->from('currency_info')
                                                                ->where('currency_id',$currency_new_id)
                                                                ->get()
                                                                ->row();

                                            $target_con_rate = $cur_info->convertion_rate;
                                            $position1 = $cur_info->currency_position;
                                            $currency1 = $cur_info->currency_icon;
                                        }
                                    ?>

                                    <?php echo $shipping_method->details?> - 

                                    <?php
                                        if ($target_con_rate > 1) {
                                            $price = $shipping_method->charge_amount * $target_con_rate;
                                            echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                        }

                                        if ($target_con_rate <= 1) {
                                            $price = $shipping_method->charge_amount * $target_con_rate;
                                            echo (($position1==0)?$currency1." ".number_format($price, 2, '.', ','):number_format($price, 2, '.', ',')." ".$currency1);
                                        }
                                    ?>
                                </label>
                            </div>
                            <?php
                                }
                            }
                            ?>

                            <div class="form-group">
                                <label class="control-label"><?php echo display('add_coment_about_your_order')?></label>
                                <textarea rows="8" class="form-control" id="delivery_details"><?php echo $this->session->userdata('delivery_details')?></textarea>
                            </div>
                        </div>
                    </div>-->
                    <div id="step-3">
                        <div id="form-step-2" role="form" data-toggle="validator" class="step3_inner">
                            <p><?php echo display('kindly_select_the_preferred_shipping_method_to_use_on_this_order')?></p>

                            <!-- Cash on delivery payment method -->
                            <div class="radio">
                                <label>    
                                    <input type="radio" name="payment_method" value="1" <?php if ($this->session->userdata('payment_method') == 1) {echo "checked ='checked'";} ?> checked>
                                    <?php echo display('cash_on_delivery')?>
                                 </label>
                            </div>

                            <?php
                            if ($bitcoin_status == 1) {
                            ?>
                            <!-- Bit coin payment method -->
                            <div class="radio">
                                <label>        
                                   <input type="radio" name="payment_method" value="3" <?php if ($this->session->userdata('payment_method') == 3 ) { echo "checked = 'checked'"; } ?>>
                                   <img src="<?php echo base_url('my-assets/image/bitcoin.png')?>">
                                    <!-- <?php echo display('bitcoin')?> -->
                                 </label>
                            </div>
                            <?php } ?>

                            <?php
                            if ($payeer_status == 1) {
                            ?>
                            <!-- Payeer payment method -->
                            <div class="radio">
                                <label>        
                                   <input type="radio" name="payment_method" value="4" <?php if ($this->session->userdata('payment_method') == 4 ) { echo "checked = 'checked'"; } ?>>
                                    <img src="<?php echo base_url('my-assets/image/payeer.png')?>">
                                 </label>
                            </div>
                            <?php } ?>

                            <?php
                            if ($paypal_status == 1) {
                            ?>
                            <!-- Payeer payment method -->
                            <div class="radio">
                                <label>        
                                   <input type="radio" name="payment_method" value="5" <?php if ($this->session->userdata('payment_method') == 5 ) { echo "checked = 'checked'"; } ?>>
                                    <img src="<?php echo base_url('my-assets/image/paypal.png')?>">
                                 </label>
                            </div>
                            <?php } ?>

                            <div class="form-group">
                                <label class="control-label"><?php echo display('add_coment_about_your_payment')?></label>
                                <textarea rows="8" class="form-control" id="payment_details"><?php echo $this->session->userdata('payment_details')?></textarea>
                            </div>
                        </div>

                    </div>
                    <div id="step-4">
                        <div id="form-step-3" role="form" data-toggle="validator" class="step4_inner">
                            <div class="step4_inner">
                                <table class="table table-bordered table-hover"> 
                                    <thead> 
                                        <tr> 
                                            <td><?php echo display('product_name')?></td> 
                                            <td><?php echo display('model')?></td> 
                                            <td><?php echo display('variant')?></td> 
                                            <td><?php echo display('quantity')?></td> 
                                            <td><?php echo display('price')?></td> 
                                            <td><?php echo display('discount')?></td> 
                                            <td><?php echo display('total')?></th> 
                                        </tr> 
                                    </thead> 
                                    <tbody> 
                                        <?php $i = 1; $cgst = 0; $sgst = 0; $igst = 0; $discount = 0;$coupon_amnt=0; ?>
                                        <?php
                                        foreach ($this->cart->contents() as $items):
                                        ?>
                                        <?php echo form_hidden($i.'[rowid]', $items['rowid']);

                                            if (!empty($items['options']['cgst'])) {
                                               $cgst = $cgst + ($items['options']['cgst'] * $items['qty']);
                                            }

                                            if (!empty($items['options']['sgst'])) {
                                               $sgst = $sgst + ($items['options']['sgst'] * $items['qty']);
                                            }

                                            if (!empty($items['options']['igst'])) {
                                               $igst = $igst + ($items['options']['igst'] * $items['qty']);
                                            }

                                            //Calculation for discount
                                            if (!empty($items['discount'])) {
                                               $discount = $discount + ($items['discount'] * $items['qty']) + $this->session->userdata('coupon_amnt');
                                               $this->session->set_userdata('total_discount',$discount);
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo base_url('product_details/'.$items['product_id'])?>"><?php echo $items['name']; ?></a>
                                            </td>
                                            <td><?php echo $items['options']['model']; ?></td>
                                            <td>
                                            <?php
                                                if (!empty($items['variant'])) {
                                                    $this->db->select('variant_name');
                                                    $this->db->from('variant');
                                                    $this->db->where('variant_id',$items['variant']);
                                                    $query = $this->db->get();
                                                    $var = $query->row();
                                                    echo $var->variant_name;
                                                }
                                            ?> 
                                            </td>
                                            <td><?php echo $items['qty']; ?></td>
                                            <td><?php echo (($position==0)?$currency." ". $this->cart->format_number($items['actual_price']):$this->cart->format_number($items['actual_price'])." ". $currency) ?></td>       

                                            <td><?php echo (($position==0)?$currency." ". $this->cart->format_number($items['discount']):$this->cart->format_number($items['discount'])." ". $currency) ?></td>

                                            <td><?php echo (($position==0)?$currency ." ". $this->cart->format_number($items['actual_price'] * $items['qty']):$this->cart->format_number($items['actual_price'] * $items['qty'])." ". $currency) ?></td>
                                        </tr>

                                        <?php $i++;?>
                                        <?php endforeach; ?>
                                       
                                    </tbody> 

                                    <tfoot>
                                         
                                        <tr>
                                            <td colspan="6" class="text-right"><strong><?php echo display('total_discount')?>:</strong></td>
                                            <td class="text-right"><?php echo (($position==0)?$currency ." ". number_format($discount, 2, '.', ','):number_format($discount, 2, '.', ',')." ". $currency)?></td>
                                        </tr>
                                        <?php
                                        $total_tax = $cgst+$sgst+$igst;
                                        if ($total_tax > 0) {
                                        ?> 
                                        <tr>
                                            <td colspan="6" class="text-right"><strong><?php echo display('total_tax')?>:</strong></td>
                                            <td class="text-right">
                                            <?php 
                                                $total_tax = $cgst+$sgst+$igst;
                                                $this->_cart_contents['total_tax'] = $total_tax;
                                                echo (($position==0)?$currency ." ". number_format($total_tax, 2, '.', ','):number_format($total_tax, 2, '.', ',')." ". $currency)?>
                                            </td>
                                        </tr>
                                        <?php 
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-right"><strong><?php echo $this->_cart_contents['cart_ship_name']?>:</strong></td>
                                            <td class="text-right">
                                            <?php
                                                $total_ship_cost = $this->_cart_contents['cart_ship_cost'];
                                                $this->session->set_userdata('cart_ship_cost',$total_ship_cost);
                                                echo (($position==0)?$currency ." ". number_format($total_ship_cost, 2, '.', ','):number_format($total_ship_cost, 2, '.', ',')." ". $currency);
                                            ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $coupon_amnt = $this->session->userdata('coupon_amnt');
                                        if ($coupon_amnt > 0) {
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-right">
                                                <strong><?php echo display('coupon_discount')?>:</strong>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                if ($coupon_amnt > 0) {
                                                echo (($position==0)?$currency ." ". number_format($coupon_amnt, 2, '.', ','):number_format($coupon_amnt, 2, '.', ',')." ". $currency);
                                                }

                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-right"><strong><?php echo display('total')?>:</strong></td>
                                            <td class="text-right">
                                            <?php 
                                                $cart_total = $this->cart->total() + $this->_cart_contents['cart_ship_cost'] + $total_tax - $coupon_amnt;

                                                $this->session->set_userdata('cart_total',$cart_total);

                                                $total_amnt = $this->_cart_contents['cart_total'] = $cart_total;

                                                echo (($position==0)?$currency ." ". number_format($total_amnt, 2, '.', ','):number_format($total_amnt, 2, '.', ',')." ". $currency);
                                            ?>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table> 
                            </div>
                      
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--========= End CheckOut Area ==========-->
<?php
}else{
?>
<!--========== Page Header Area ==========-->
<section class="page_header">
    <div class="container">
        <div class="row m0 page_header_inner">
            <h2 class="page_title"><?php echo display('cart')?></h2>
            <ol class="breadcrumb m0 p0">
                <li class="breadcrumb-item"><a href="<?php echo base_url()?>"><?php echo display('home')?></a></li>
                <li class="breadcrumb-item active"><?php echo display('cart_empty')?></li>
            </ol>
        </div>
    </div>
</section>
<!--========== End Page Header Area ==========-->

<!--========== Empty Cart Area ==========-->
<section class="shopping_cart_area">
    <div class="container">
        <div class="row db empty_cart">
            <img src="<?php echo base_url()?>assets/website/image/oops.png" alt="oops image">
            <h2 class="page_title"><?php echo display('oops_your_cart_is_empty')?></h2>
            <a href="<?php echo base_url()?>" class="base_button"><?php echo display('got_to_shop_now')?></a>
        </div>
    </div>
</section>
<!--========== End Empty Cart Area ==========-->
<?php
}
?>

<!-- Push delivery cost to cache by ajax -->
<script type="text/javascript">
    //Retrive district
    $('body').delegate('.sw-btn-next', 'click', function() {
        var first_name      = $('#first_name').val();
        var last_name       = $('#last_name').val();
        var customer_email  = $('#customer_email').val();
        var customer_mobile = $('#customer_mobile').val();
        var customer_address_1 = $('#customer_address_1').val();
        var customer_address_2 = $('#customer_address_2').val();
        var company         = $('#company').val();
        var city            = $('#city').val();
        var zip             = $('#zip').val();
        var country         = $('#country').val();
        var state           = $('#state').val();
        var password        = $('#password').val();
        var privacy_policy  = $('#privacy_policy').attr("checked") ? 1 : 0;
        var ship_and_bill   = $("#ship_and_bill").attr("checked") ? 1 : 0;

        var ship_first_name = $('#ship_first_name').val();
        var ship_last_name  = $('#ship_last_name').val();
        var ship_company    = $('#ship_company').val();
        var ship_mobile     = $('#ship_mobile').val();
        var ship_address_1  = $('#ship_address_1').val();
        var ship_address_2  = $('#ship_address_2').val();
        var ship_city       = $('#ship_city').val();
        var ship_zip        = $('#ship_zip').val();
        var ship_country    = $('#ship_country').val();
        var ship_state      = $('#ship_state').val();
        var payment_method  = $('input[name=\'payment_method\']:checked').val();
        var delivery_details= $('#delivery_details').val();
        var payment_details = $('#payment_details ').val();
        
        $.ajax({
            type: "post",
            url: '<?php echo base_url('website/Home/account_info_save/')?>' + $('input[name=\'account\']:checked').val(),
            data: {
                first_name:first_name,
                last_name:last_name,
                customer_email:customer_email,
                customer_mobile:customer_mobile,
                customer_address_1:customer_address_1,
                customer_address_2:customer_address_2,
                company:company,
                city:city,
                zip:zip,
                country:country,
                state:state,
                password:password,
                ship_and_bill:ship_and_bill,
                privacy_policy:privacy_policy,
                ship_first_name:ship_first_name,
                ship_last_name:ship_last_name,
                ship_company:ship_company,
                ship_mobile:ship_mobile,
                ship_address_1:ship_address_1,
                ship_address_2:ship_address_2,
                ship_city:ship_city,
                ship_zip:ship_zip,
                ship_country:ship_country,
                ship_state:ship_state,
                payment_method:payment_method,
                delivery_details:delivery_details,
                payment_details:payment_details,
            },
           
            beforeSend: function() {
                $('#button-account').button('loading');
            },
            complete: function() {
                $('#button-account').button('reset');
            },
            success: function(html) {
                // location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }); 
</script>
<!-- Push delivery cost to cache by ajax  -->

<script type="text/javascript">
    function account_type(){
        var account_type  = $('input[name=\'account\']:checked').val();
        $.ajax({
            type: "post",
            url: '<?php echo base_url('website/Home/account_type_save/')?>',
            data: { account_type:account_type },
           
            beforeSend: function() {
                $('#button-account').button('loading');
            },
            complete: function() {
                $('#button-account').button('reset');
            },
            success: function(html) {
                location.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
</script>

<!-- if ship and billing info are same -->
<script type="text/javascript">
    function checkboxcheck(){
        var total_qntt  ='ship_and_bill';

        var first_name      = $('#first_name').val();
        var last_name       = $('#last_name').val();
        var customer_email  = $('#customer_email').val();
        var customer_mobile = $('#customer_mobile').val();
        var customer_address_1 = $('#customer_address_1').val();
        var customer_address_2 = $('#customer_address_2').val();
        var company         = $('#company').val();
        var city            = $('#city').val();
        var zip             = $('#zip').val();
        var country         = $('#country').val();
        var state           = $('#state').val();
        var password        = $('#password').val();
        var privacy_policy  = $('#privacy_policy').attr("checked") ? 1 : 0;
        var ship_first_name = $('#ship_first_name').val();
        var ship_last_name  = $('#ship_last_name').val();
        var ship_company    = $('#ship_company').val();
        var ship_mobile     = $('#ship_mobile').val();
        var ship_address_1  = $('#ship_address_1').val();
        var ship_address_2  = $('#ship_address_2').val();
        var ship_city       = $('#ship_city').val();
        var ship_zip        = $('#ship_zip').val();
        var ship_country    = $('#ship_country').val();
        var ship_state      = $('#ship_state').val();
        var payment_method  = $('input[name=\'payment_method\']:checked').val();
        var delivery_details= $('#delivery_details').val();
        var payment_details = $('#payment_details ').val();

        if($('#'+total_qntt).prop("checked") == true){
            document.getElementById(total_qntt).setAttribute("checked","checked");

            var ship_and_bill   = $("#ship_and_bill").attr("checked") ? 1 : 0;
               
            $.ajax({
                type: "post",
                url: '<?php echo base_url('website/Home/account_info_save/')?>' + $('input[name=\'account\']:checked').val(),
                data: { 

                    first_name:first_name,
                    last_name:last_name,
                    customer_email:customer_email,
                    customer_mobile:customer_mobile,
                    customer_address_1:customer_address_1,
                    customer_address_2:customer_address_2,
                    company:company,
                    city:city,
                    zip:zip,
                    country:country,
                    state:state,
                    password:password,
                    ship_and_bill:ship_and_bill,
                    privacy_policy:privacy_policy,
                    ship_first_name:ship_first_name,
                    ship_last_name:ship_last_name,
                    ship_company:ship_company,
                    ship_mobile:ship_mobile,
                    ship_address_1:ship_address_1,
                    ship_address_2:ship_address_2,
                    ship_city:ship_city,
                    ship_zip:ship_zip,
                    ship_country:ship_country,
                    ship_state:ship_state,
                    payment_method:payment_method,
                    delivery_details:delivery_details,
                    payment_details:payment_details,

                 },
               
                beforeSend: function() {
                    $('#button-account').button('loading');
                },
                complete: function() {
                    $('#button-account').button('reset');
                },
                success: function(html) {
                    location.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

        }else if($('#'+total_qntt).prop("checked") == false){
            document.getElementById(total_qntt).removeAttribute("checked");

            var ship_and_bill   = $("#ship_and_bill").attr("checked") ? 1 : 0;
               
            $.ajax({
                type: "post",
                url: '<?php echo base_url('website/Home/account_info_save/')?>' + $('input[name=\'account\']:checked').val(),
                data: { 
                    first_name:first_name,
                    last_name:last_name,
                    customer_email:customer_email,
                    customer_mobile:customer_mobile,
                    customer_address_1:customer_address_1,
                    customer_address_2:customer_address_2,
                    company:company,
                    city:city,
                    zip:zip,
                    country:country,
                    state:state,
                    password:password,
                    ship_and_bill:ship_and_bill,
                    privacy_policy:privacy_policy,
                    ship_first_name:ship_first_name,
                    ship_last_name:ship_last_name,
                    ship_company:ship_company,
                    ship_mobile:ship_mobile,
                    ship_address_1:ship_address_1,
                    ship_address_2:ship_address_2,
                    ship_city:ship_city,
                    ship_zip:ship_zip,
                    ship_country:ship_country,
                    ship_state:ship_state,
                    payment_method:payment_method,
                    delivery_details:delivery_details,
                    payment_details:payment_details,

                 },
               
                beforeSend: function() {
                    $('#button-account').button('loading');
                },
                complete: function() {
                    $('#button-account').button('reset');
                },
                success: function(html) {

                    location.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    };

    function checkboxcheck_privacy(){
        var total_qntt  ='privacy_policy';
        if($('#'+total_qntt).prop("checked") == true){
            document.getElementById(total_qntt).setAttribute("checked","checked");
        }
        else if($('#'+total_qntt).prop("checked") == false){
            document.getElementById(total_qntt).removeAttribute("checked");
        }
    };
</script>

<script type="text/javascript">
    $(document).ready(function(){
        // Toolbar extra buttons
        var btnFinish = $('<button></button>').text('<?php echo display('submit')?>').addClass('btn submit_btn').on('click', function(){ 
            if( !$(this).hasClass('disabled')){ 
                var elmForm = $("#myForm");
                if(elmForm){
                    elmForm.validator('validate'); 
                    var elmErr = elmForm.find('.has-error');
                    if(elmErr && elmErr.length > 0){
                        alert('<?php echo display('please_fill_up_all_required_field')?>');
                        return false;    
                    }else{
                        var x = confirm('<?php echo display('are_you_sure_want_to_order')?>');
                        if (x==true){
                            elmForm.submit();
                            return false;
                        }
                        return false;
                    }
                }
            }
        });
        var btnCancel = $('<button></button>').text('Cancel').addClass('btn btn_cancel').on('click', function(){ 
            $('#wizard_form').smartWizard("reset"); 
            $('#myForm').find("input, textarea").val(""); 
        }); 

        // Smart Wizard
        $('#wizard_form').smartWizard({ 
            selected: 0, 
            theme: 'dots',
            transitionEffect:'fade',
            toolbarSettings: {toolbarPosition: 'bottom',
                toolbarExtraButtons: [btnFinish, btnCancel]
            },
            anchorSettings: {
                markDoneStep: true, // add done css
                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
            }
         });
        
        $("#wizard_form").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
			var elmForm = $("#form-step-" + stepNumber);
            // stepDirection === 'forward' :- this condition allows to do the form validation 
            // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
            if(stepDirection === 'forward' && elmForm){
				elmForm.validator('validate'); 
                var elmErr = elmForm.children('.has-error');
				console.log(elmForm);
				console.log(elmErr);
				if(elmErr && elmErr.length > 0){
                    // Form validation failed
					return false;    
                }
            }
            return true;
        });
        
        $("#wizard_form").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
            // Enable finish button only on last step
            if(stepNumber == 4){ 
                $('.btn-finish').removeClass('disabled');  
            }else{
                $('.btn-finish').addClass('disabled');
            }
        });                               
        
    });   
</script>

<!-- Retrive district ajax code start-->
<script type="text/javascript">
    //Retrive district
    $('body').on('change', '#country', function() {
        var country_id = $('#country').val();
        if (country_id == 0) {
            alert('<?php echo display('please_select_country')?>');
            return false;
        }
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/retrive_district')?>',
            data: {country_id:country_id},
            success: function(data) {
                if (data) {
                    $("#state").html(data);
                }else{
                    $("#state").html('<p style="color:red"><?php echo display('failed')?></p>'); 
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }); 
</script>
<!-- Retrive district ajax code end-->

<!-- Retrive shipping district ajax code start-->
<script type="text/javascript">
    //Retrive district
    $('body').on('change', '#ship_country', function() {
        var country_id = $('#ship_country').val();
        if (country_id == 0) {
            alert('<?php echo display('please_select_country')?>');
            return false;
        }
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/retrive_district')?>',
            data: {country_id:country_id},
            success: function(data) {

                if (data) {
                    $("#ship_state").html(data);
                }else{
                    $("#ship_state").html('<p style="color:red"><?php echo display('failed')?></p>'); 
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }); 
</script>
<!-- Retrive shipping district ajax code end -->

<!-- Push delivery cost to cache by ajax -->
<script type="text/javascript">
    //Retrive district
    $('body').on('click', '.shipping_cost', function() {
        var shipping_cost  = $(this).val();
        var ship_cost_name = $(this).attr('alt');
        var method_id      = $(this).attr('id');
        $.ajax({
            type: "post",
            async: true,
            url: '<?php echo base_url('website/Home/set_ship_cost_cart')?>',
            data: {shipping_cost:shipping_cost,ship_cost_name:ship_cost_name,method_id:method_id},
            success: function(data) {
                location.reload();
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }); 
</script>
<!-- Push delivery cost to cache by ajax  -->
<script type="text/javascript">
    $(document).ready(function() {
    var table = $('#invoices').DataTable({
		"scrollX": true,
		"language": {
                "url": "assets/website/vendor/datatables/Spanish.json"
		},
		"bFilter": false,
		"bLengthChange": false,
		"pageLength": 3
	});
	
	$('#invoices tbody').on( 'click', 'tr', function () {
	
		table.$('tr.selected').removeClass('selected');
		$(this).addClass('selected');
	
		var rowData = table.row( this ).data();
		console.log(rowData);
		$('#customer_rfc').val(rowData[3]);
		$('#customer_email').val(rowData[5]);
		$('#customer_variant').val(rowData[1]);
		$('#customer_street').val(rowData[6]);
		$('#customer_inter_number').val(rowData[13]);
		$('#customer_exter_number').val(rowData[14]);
		$('#customer_colony').val(rowData[7]);
		$('#customer_delegation').val(rowData[8]);
		$('#customer_state').val(rowData[9]);
		$('#customer_zip').val(rowData[10]);
		$('#customer_name').val(rowData[15]);
		$('#customer_first_lastname').val(rowData[11]);
		$('#customer_secon_lastname').val(rowData[12]);
		$('#customer_social_reason').val(rowData[16]);
		
		
		var customer_variant = $('#customer_variant option:selected').val();
        if (customer_variant == 1) {
            $('#group_customer_name').css({'display': 'block'});
            $('#group_customer_first_lastname').css({'display': 'block'});
			$('#group_customer_secon_lastname').css({'display': 'block'});
            $('#group_customer_social_reason').css({'display': 'none'});
			$('#customer_social_reason').removeAttr("required");
			$('#customer_name').prop('required',true);
        }else if (customer_variant == 2){
            $('#group_customer_name').css({'display': 'none'});
            $('#group_customer_first_lastname').css({'display': 'none'});
			$('#group_customer_secon_lastname').css({'display': 'none'});
            $('#group_customer_social_reason').css({'display': 'block'});
			$('#customer_name').removeAttr("required");
			$('#customer_social_reason').prop('required',true);
        }
        else
        {
            $('#group_customer_name').css({'display': 'none'});
            $('#group_customer_first_lastname').css({'display': 'none'});
			$('#group_customer_secon_lastname').css({'display': 'none'});
            $('#group_customer_social_reason').css({'display': 'none'});
			$("#customer_social_reason").removeAttr("required");
			$("#customer_name").removeAttr("required");
		}
	 
	  
	} );
	
} );
</script>

<script type="text/javascript">
    $('#group_customer_social_reason').css({'display': 'none'});
    $('#group_customer_name').css({'display': 'none'});
    $('#group_customer_first_lastname').css({'display': 'none'});
	$('#group_customer_secon_lastname').css({'display': 'none'});

    $('#customer_variant').on('change', function() {
        var customer_variant = $('#customer_variant option:selected').val();
        if (customer_variant == 1) {
            $('#group_customer_name').css({'display': 'block'});
            $('#group_customer_first_lastname').css({'display': 'block'});
			$('#group_customer_secon_lastname').css({'display': 'block'});
            $('#group_customer_social_reason').css({'display': 'none'});
			$('#customer_social_reason').removeAttr("required");
			$('#customer_name').prop('required',true);
        }else if (customer_variant == 2){
            $('#group_customer_name').css({'display': 'none'});
            $('#group_customer_first_lastname').css({'display': 'none'});
			$('#group_customer_secon_lastname').css({'display': 'none'});
            $('#group_customer_social_reason').css({'display': 'block'});
			$('#customer_name').removeAttr("required");
			$('#customer_social_reason').prop('required',true);
        }
        else
        {
            $('#group_customer_name').css({'display': 'none'});
            $('#group_customer_first_lastname').css({'display': 'none'});
			$('#group_customer_secon_lastname').css({'display': 'none'});
            $('#group_customer_social_reason').css({'display': 'none'});
			$("#customer_social_reason").removeAttr("required");
			$("#customer_name").removeAttr("required");
        }
    });
</script>

<script type="text/javascript">
    
</script>