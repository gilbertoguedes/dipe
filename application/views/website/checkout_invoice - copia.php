<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
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
        <form action="<?php echo base_url('submit_checkout_invoice')?>" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" >

            <!-- SmartWizard html -->
            <div id="wizard_form">
                <ul>
                    <li><a href="#step-3"><?php /*echo display('electronic_billing')*/ echo "Datos del Receptor"?></a></li>
                    <li><a href="#step-4"><?php /*echo display('electronic_billing')*/ echo "Comprobante"?></a></li>
                </ul>

                <div class="wizard_inner">
                    <div id="step-3">
                        <div id="form-step-0" role="form" data-toggle="validator" class="row step1_inner">
                            <div class="form-group col-sm-12">
                                <table id="data_invoice" class="display" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="width : 130px; min-width : 130px"><?php echo display('action') ?></th>
                                        <th style="display:none;"><?php echo display('variant_id') ?></th>
                                        <th style="width : 150px; min-width : 150px"><?php echo display('variant') ?></th>
                                        <th style="width : 150px; min-width : 150px"><?php echo display('rfc') ?></th>
                                        <th style="width : 150px; min-width : 150px"><?php echo display('name') ?> / <?php echo display('social_reason') ?></th>
                                        <th style="display:none;"><?php echo display('customer_name') ?>
                                        <th style="display:none;"><?php echo display('customer_first_lastname') ?></th>
                                        <th style="display:none;"><?php echo display('customer_secon_lastname') ?></th>
                                        <!--<th style="width : 150px; min-width : 150px"><?php echo display('email') ?></th>
                                        <th style="width : 200px; min-width : 200px"><?php echo display('address') ?></th>
                                        <th><?php echo display('colony') ?></th>
                                        <th><?php echo display('delegation') ?></th>
                                        <th><?php echo display('state') ?></th>
                                        <th><?php echo display('zip') ?></th>
                                        <th style="display:none;"><?php echo display('customer_inter_number') ?></th>
                                        <th style="display:none;"><?php echo display('customer_exter_number') ?></th>
                                        <th style="display:none;"><?php echo display('customer_name') ?></th>
                                        <th style="display:none;"><?php echo display('customer_street') ?></th>
                                        <th style="display:none;"><?php echo display('customer_first_lastname') ?></th>
                                        <th style="display:none;"><?php echo display('customer_secon_lastname') ?></th>-->
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
                                                <td style="display:none;"><?php echo $data['customer_name'];  ?></td>
                                                <td style="display:none;"><?php echo $data['customer_first_lastname'];  ?></td>
                                                <td style="display:none;"><?php echo $data['customer_secon_lastname'];  ?></td>
                                                <!--<td><?php echo $data['customer_email']; ?></td>
                                                <td><?php echo $data['customer_street'].' Número Exterior - '.$data['customer_exter_number'].' Número Interior - '.$data['customer_inter_number']; ?></td>
                                                <td><?php echo $data['customer_colony']; ?></td>
                                                <td><?php echo $data['customer_delegation']; ?></td>
                                                <td><?php echo $data['customer_state']; ?></td>
                                                <td><?php echo $data['customer_zip']; ?></td>
                                                <td style="display:none;"><?php echo $data['customer_inter_number'];  ?></td>
                                                <td style="display:none;"><?php echo $data['customer_exter_number'];  ?></td>
                                                <td style="display:none;"><?php echo $data['customer_name'];  ?></td>
                                                <td style="display:none;"><?php echo $data['customer_street'];  ?></td>
                                                <td style="display:none;"><?php echo $data['customer_first_lastname'];  ?></td>
                                                <td style="display:none;"><?php echo $data['customer_secon_lastname'];  ?></td>-->
                                            </tr>
                                        <?php } ?>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo "Uso de CDFI";/*display('kind_of_person')*/?> <i class="text-danger">*</i></label>
                                <select class="form-control" name="fac_uso" id="fac_uso" required>
                                    <option value=""><?php echo display('select_one')?></option>
                                    <option value="P01"> Por definir</option>
                                    <option value="G01"> Adquisición de mercancías</option>
                                    <option value="G02"> Devoluciones, descuentos o bonificaciones</option>
                                    <option value="G03"> Gastos en general</option>
                                    <option value="I01"> Construcciones</option>
                                    <option value="I02"> Moviliario y equipo de oficina por inversiones</option>
                                    <option value="I03"> Equipo de transporte</option>
                                    <option value="I04"> Equipo de cómputo y accesorios</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div id="groupSaveData" class="form-group col-sm-12">
                                <input type="hidden" id="idOrder"  name="idOrder" value="<?php echo $idOrder; ?>"/>
                                <input type="hidden" id="customer_save_data"  name="customer_save_data" value="0"/>
                                <input type="checkbox" onclick="checkboxSaveData()" id="checkbox_customer_save_data" > Salvar datos
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('kind_of_person')?> <i class="text-danger">*</i></label>
                                <select class="form-control" name="customer_variant" id="customer_variant" required>
                                    <option value=""><?php echo display('select_one')?></option>
                                    <option value="1"><?php echo display('physics_person')?></option>
                                    <option value="2"><?php echo display('morale_person')?></option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('rfc')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('rfc') ?>" class="form-control" id="customer_rfc" name="customer_rfc" required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <!--<div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('email')?> <i class="text-danger">*</i></label>
                                <input type="email" placeholder="<?php echo display('email') ?>" class="form-control" id="customer_email" name="customer_email" value="<?php echo $this->session->userdata('customer_email')?>" required />
                                <div class="help-block with-errors"></div>
                            </div>-->
                            <div id="groupCustomerSocialReason" class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('social_reason')?> <i class="text-danger">*</i></label>
                                <textarea  class="form-control" id="customer_social_reason" name="customer_social_reason" /></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div id="groupCustomerName" class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('name')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('name') ?>" class="form-control" id="customer_name" name="customer_name"  />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div id="groupCustomerFirstLastName" class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('customer_first_lastname')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('customer_first_lastname') ?>" class="form-control" id="customer_first_lastname" name="customer_first_lastname"/>
                            </div>
                            <div id="groupCustomerSeconLastName" class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('customer_secon_lastname')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('customer_secon_lastname') ?>" class="form-control" id="customer_secon_lastname" name="customer_secon_lastname"/>
                            </div>
                            <!--<div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('street')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('street') ?>" class="form-control" id="customer_street" name="customer_street" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('exter_number')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('exter_number') ?>" class="form-control" id="customer_exter_number" name="customer_exter_number" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('inter_number')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('inter_number') ?>" class="form-control" id="customer_inter_number" name="customer_inter_number" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('colony')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('colony') ?>" class="form-control" id="customer_colony" name="customer_colony" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('delegation'); echo " / "; echo display('municipality'); ?></label>
                                <input type="text" placeholder="<?php echo display('delegation'); echo " / "; echo display('municipality'); ?>" class="form-control" id="customer_delegation" name="customer_delegation" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('state')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('state') ?>" class="form-control" id="customer_state" name="customer_state" />
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo display('zip')?> <i class="text-danger">*</i></label>
                                <input type="text" placeholder="<?php echo display('zip') ?>" class="form-control" id="customer_zip" name="customer_zip" />
                            </div>-->
                        </div>
                    </div>
                    <div id="step-4">
                        <div id="form-step-0" role="form" data-toggle="validator" class="row step1_inner">
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo "Forma de Pago";/*display('kind_of_person')*/?> <i class="text-danger">*</i></label>
                                <select class="form-control" name="fac_fp" id="fac_fp" required>
                                    <option value=""><?php echo display('select_one')?></option>
                                    <option value="01"> Efectivo</option>
                                    <option value="02"> Cheque nominativo</option>
                                    <option value="03"> Transferencia electrónica de fondos (incluye SPEI)</option>
                                    <option value="04"> Targeta de crédito</option>
                                    <option value="15"> Condonación</option>
                                    <option value="31"> Intermediarios de pago</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label  class="control_label"><?php echo "Método de Pago";/*display('kind_of_person')*/?> <i class="text-danger">*</i></label>
                                <select class="form-control" name="fac_mp" id="fac_mp" required>
                                    <option value=""><?php echo display('select_one')?></option>
                                    <option value="PPD"> Pago en parcialidades o diferido</option>
                                    <option value="PUE"> Pago en una sola exhibición</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </form>
    </div>
</section>
<!--========= End CheckOut Area ==========-->
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
            url: '<?php echo base_url('website/Home/account_info_save/')?>' + '1'/*$('input[name=\'account\']:checked').val()*/,
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
                payment_details:payment_details
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

<script type="text/javascript">
    function checkboxSaveData(){
        if($('#checkbox_customer_save_data').prop("checked") == true){
            $('#customer_save_data').val("1");
            console.log($('#customer_save_data').val());
        }
        else
        {
            $('#customer_save_data').val("0");
            console.log($('#customer_save_data').val());
        }
    }
</script>

<!-- if ship and billing info are same -->
<script type="text/javascript">
    function checkboxcheck(){


        console.log("adasdsdsadsadsdasdasdasdsads");

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
                url: '<?php echo base_url('website/Home/account_info_save/')?>' + "1",
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
                    payment_details:payment_details

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
        var btnFinish = $('<button></button>').text('<?php echo display('check_in')?>').addClass('btn submit_btn').on('click', function(){
            if( !$(this).hasClass('disabled')){ 
                var elmForm = $("#myForm");
                if(elmForm){
                    elmForm.validator('validate'); 
                    var elmErr = elmForm.find('.has-error');
                    if(elmErr && elmErr.length > 0){
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
        var btnCancel = $('<button></button>').text('<?php echo display('cancel')?>').addClass('btn btn_cancel').on('click', function(){
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
    var table = $('#data_invoice').DataTable({
		"scrollX": true,
		"language": {
                "url": "/assets/website/vendor/datatables/Spanish.json"
		},
		"bFilter": false,
		"bLengthChange": false,
		"pageLength": 3
	});
	
	$('#data_invoice tbody').on( 'click', 'tr', function () {
	
		table.$('tr.selected').removeClass('selected');
		$(this).addClass('selected');
	
		var rowData = table.row( this ).data();
		console.log(rowData);

        $('#customer_variant').val(rowData[1]);
		//$('#customer_phone_number').val(rowData[2]);
        $('#customer_rfc').val(rowData[3]);
        $('#customer_social_reason').val(rowData[4]);
        //$('#customer_email').val(rowData[5]);
		//$('#customer_colony').val(rowData[7]);
		//$('#customer_delegation').val(rowData[8]);
		//$('#customer_state').val(rowData[9]);
		//$('#customer_zip').val(rowData[10]);
		//$('#customer_inter_number').val(rowData[11]);
		//$('#customer_exter_number').val(rowData[12]);
		$('#customer_name').val(rowData[5]);
		//$('#customer_street').val(rowData[6]);
        $('#customer_first_lastname').val(rowData[6]);
        $('#customer_secon_lastname').val(rowData[7]);

		
		
		
		var customer_variant = $('#customer_variant option:selected').val();
        if (customer_variant == 1) {
            $('#groupCustomerName').css({'display': 'block'});
            $('#groupCustomerFirstLastName').css({'display': 'block'});
            $('#groupCustomerSeconLastName').css({'display': 'block'});
            $('#groupCustomerSocialReason').css({'display': 'none'});

            $('#customer_name').prop('required',true);
            $('#customer_first_lastname').prop('required',true);
            $('#customer_secon_lastname').prop('required',true);
            $('#customer_social_reason').removeAttr("required");

        }else if (customer_variant == 2){
            $('#groupCustomerName').css({'display': 'none'});
            $('#groupCustomerFirstLastName').css({'display': 'none'});
            $('#groupCustomerSeconLastName').css({'display': 'none'});
            $('#groupCustomerSocialReason').css({'display': 'block'});

            $('#customer_name').removeAttr("required");
            $('#customer_first_lastname').removeAttr("required");
            $('#customer_secon_lastname').removeAttr("required");
            $('#customer_social_reason').prop('required',true);
        }
        else
        {
            $('#groupCustomerName').css({'display': 'none'});
            $('#groupCustomerFirstLastName').css({'display': 'none'});
            $('#groupCustomerSeconLastName').css({'display': 'none'});
            $('#groupCustomerSocialReason').css({'display': 'none'});

            $('#customer_name').removeAttr("required");
            $('#customer_first_lastname').removeAttr("required");
            $('#customer_secon_lastname').removeAttr("required");
            $('#customer_social_reason').removeAttr("required");
        }
	 
	  
	} );
	
} );
</script>

<script type="text/javascript">
    $('#groupCustomerName').css({'display': 'none'});
    $('#groupCustomerFirstLastName').css({'display': 'none'});
    $('#groupCustomerSeconLastName').css({'display': 'none'});
    $('#groupCustomerSocialReason').css({'display': 'none'});

    $('#customer_variant').on('change', function() {
        var customer_variant = $('#customer_variant option:selected').val();
        if (customer_variant == 1) {
            $('#groupCustomerName').css({'display': 'block'});
            $('#groupCustomerFirstLastName').css({'display': 'block'});
            $('#groupCustomerSeconLastName').css({'display': 'block'});
            $('#groupCustomerSocialReason').css({'display': 'none'});

            $('#customer_name').prop('required',true);
            $('#customer_first_lastname').prop('required',true);
            $('#customer_secon_lastname').prop('required',true);
            $('#customer_social_reason').removeAttr("required");

		}else if (customer_variant == 2){
            $('#groupCustomerName').css({'display': 'none'});
            $('#groupCustomerFirstLastName').css({'display': 'none'});
            $('#groupCustomerSeconLastName').css({'display': 'none'});
            $('#groupCustomerSocialReason').css({'display': 'block'});

            $('#customer_name').removeAttr("required");
            $('#customer_first_lastname').removeAttr("required");
            $('#customer_secon_lastname').removeAttr("required");
            $('#customer_social_reason').prop('required',true);
        }
        else
        {
            $('#groupCustomerName').css({'display': 'none'});
            $('#groupCustomerFirstLastName').css({'display': 'none'});
            $('#groupCustomerSeconLastName').css({'display': 'none'});
            $('#groupCustomerSocialReason').css({'display': 'none'});

            $('#customer_name').removeAttr("required");
            $('#customer_first_lastname').removeAttr("required");
            $('#customer_secon_lastname').removeAttr("required");
            $('#customer_social_reason').removeAttr("required");
        }
    });
</script>

<script type="text/javascript">
    
</script>