<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- ========== CheckOut Area -->
<section class="checkout section-content bg padding-y-sm dipe-section-content">
    <div class="container">
        <div class="card p-5">

            <div class="row justify-content-center">
                <div class="col-md-5 col-sm-6 col-lg-4">
                    <?php
                    $message = $this->session->userdata('message');
                    if ($message) {
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $message?>
                        </div>
                        <?php
                        $this->session->unset_userdata('message');
                    }
                    ?>
                    <?php
                    $error_message = $this->session->userdata('error_message');
                    if ($error_message) {
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $error_message?>
                        </div>
                        <?php
                        $this->session->unset_userdata('error_message');
                    }
                    ?>
                </div>
            </div>
            <form action="<?php echo base_url('submit_checkout_invoice')?>" onsubmit="this.querySelectorAll('input,select').forEach(i => i.disabled = false)" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8" >

                <!-- SmartWizard html -->
                <div id="wizard_form">
                    <ul>
                        <li><a href="#step-3"><?php /*echo display('electronic_billing')*/ echo "Datos del Receptor"?></a></li>
                        <li><a href="#step-4"><?php /*echo display('electronic_billing')*/ echo "Comprobante"?></a></li>
                    </ul>

                    <div class="wizard_inner">
                        <div id="step-3">
                            <div class="row justify-content-center mt-5">
                                <div class="p-xs-0 p-md-2 p-lg-4 col-lg-9">
                                    <div id="select-step-0" role="form" data-toggle="validator" >
                                        <div class="form-group">
                                            <label  class="control_label"><?php echo "Uso de CDFI";/*display('kind_of_person')*/?> <i class="text-danger">*</i></label>
                                            <select class="form-control" name="fac_uso" id="fac_uso" required data-required-error="Campo obligatorio.">
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
                                    </div>
                                </div>
                            </div>
                            <?php if ($admin_profile_invoice_data_list) { ?>
                            <div class="row justify-content-center mt-5">
                                <div class="card p-xs-0 p-md-2 p-lg-4 col-lg-9">
                                    <form class="bs-example" action="">
                                        <div class="panel-group" id="accordion">
                                            <?php foreach($admin_profile_invoice_data_list as $data) { ?>
                                                <div class="panel panel-default dipe-venta-datos-cliente-item rounded dipe-color-6">
                                                    <div class="panel-heading ">
                                                        <h4 class="panel-title">
                                                            <label class="mb-0 dipe-font-size-1" >
                                                                <input type='radio' id="<?php echo $data['customer_information_invoice_data_id'];  ?>" name='dipe-datos-facturacion' value="<?php echo $data['customer_name'].'/'.$data['customer_first_lastname'].'/'.$data['customer_secon_lastname'].'/'.$data['customer_variant'].'/'.$data['customer_rfc'].'/'.$data['customer_social_reason'].'/'.$data['customer_information_invoice_data_id'];; ?>" /> Rfc: <?php echo $data['customer_rfc']; ?>, <?php if($data['customer_variant']==1){ echo "Persona Física"; }else{ echo "Persona Moral"; } ?>
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"></a>
                                                            </label>
                                                        </h4>
                                                    </div>
                                                    <div name="dipe-datos-facturacion-collapse" id="<?php echo "collapse-".$data['customer_information_invoice_data_id'];  ?>" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <div class="box ">
                                                                <dl class="dlist-inline">
                                                                    <dt>Rfc: </dt>
                                                                    <dd><?php echo $data['customer_rfc']; ?></dd>
                                                                </dl>
                                                                <dl class="dlist-inline">
                                                                <?php if($data['customer_variant']==1){ ?>
                                                                    <dt>Nombre: </dt>
                                                                    <dd><?php echo $data['customer_name'].' '.$data['customer_first_lastname'].' '.$data['customer_secon_lastname'];  ?></dd>
                                                                <?php } else { ?>
                                                                    <dt>Razón Social: </dt>
                                                                    <dd><?php echo $data['customer_social_reason']; ?></dd>
                                                                <?php } ?>
                                                                </dl>
                                                            </div> <!-- box.// -->
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <?php } ?>
                            <div class="row justify-content-center mt-5">
                                <div class="card p-xs-0 p-md-2 p-lg-4 col-lg-9 mb-5">
                                    <div class="form-check dipe-gray-1-bg p-3" id="group_edit_data">
                                        <input class="form-check-input ml-2" onclick="checkboxEditData()" type="checkbox"  id="checkbox_customer_edit_data">
                                        <label class="form-check-label ml-4" for="checkbox_customer_edit_data">
                                            Editar Formulario
                                        </label>
                                    </div>
                                    <div class="form-check dipe-gray-1-bg p-3 mb-4">
                                        <input type="hidden" id="idOrder"  name="idOrder" value="<?php echo $idOrder; ?>"/>
                                        <input type="hidden" id="customer_save_data"  name="customer_save_data" value="<?php if ($admin_profile_invoice_data_list) { echo '0'; }else{echo '1';}?>"/>
                                        <input class="form-check-input ml-2" onclick="checkboxSaveData()"  type="checkbox" <?php if ($admin_profile_invoice_data_list==false) { echo 'checked'; }?>  id="checkbox_customer_save_data">
                                        <label class="form-check-label ml-4" for="defaultCheck1">
                                            Guardar estos datos
                                        </label>
                                    </div>
                                    <div class="form-row" id="form-row1-step-0" role="form" data-toggle="validator">
                                        <div class="col form-group">
                                            <label><?php echo display('kind_of_person')?> <i class="text-danger">*</i></label>
                                            <select class="form-control" name="customer_variant" id="customer_variant" required data-required-error="Campo obligatorio.">
                                                <option value=""><?php echo display('select_one')?></option>
                                                <option value="1"><?php echo display('physics_person')?></option>
                                                <option value="2"><?php echo display('morale_person')?></option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                        <div class="col form-group">
                                            <label><?php echo display('rfc')?> <i class="text-danger">*</i></label>
                                            <input type="text" placeholder="<?php echo display('rfc') ?>" class="form-control" id="customer_rfc" name="customer_rfc" required data-required-error="Campo obligatorio."/>
                                            <div class="help-block with-errors"></div>
                                        </div> <!-- form-group end.// -->
                                    </div> <!-- form-row end.// -->
                                    <div class="form-row" id="form-row2-step-0" role="form" data-toggle="validator">
                                        <div id="groupCustomerSocialReason" class="col form-group">
                                            <label  class="control_label"><?php echo display('social_reason')?> <i class="text-danger">*</i></label>
                                            <textarea  class="form-control" id="customer_social_reason" name="customer_social_reason" /></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div id="groupCustomerName" class="col form-group">
                                            <label  class="control_label"><?php echo display('name')?> <i class="text-danger">*</i></label>
                                            <input type="text" placeholder="<?php echo display('name') ?>" class="form-control" id="customer_name" name="customer_name"  />
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div id="groupCustomerFirstLastName" class="col form-group">
                                            <label  class="control_label"><?php echo display('customer_first_lastname')?> <i class="text-danger">*</i></label>
                                            <input type="text" placeholder="<?php echo display('customer_first_lastname') ?>" class="form-control" id="customer_first_lastname" name="customer_first_lastname"/>
                                        </div>
                                        <div id="groupCustomerSeconLastName" class="col form-group">
                                            <label  class="control_label"><?php echo display('customer_secon_lastname')?> <i class="text-danger">*</i></label>
                                            <input type="text" placeholder="<?php echo display('customer_secon_lastname') ?>" class="form-control" id="customer_secon_lastname" name="customer_secon_lastname"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-4">
                            <div class="row justify-content-center mt-5">
                                <div class="card p-xs-0 p-md-2 p-lg-4 col-lg-9 mt-5 mb-5">
                                    <div class="form-row" id="form-row1-step-1" role="form" data-toggle="validator">
                                        <div class="col form-group">
                                            <label  class="control_label"><?php echo "Forma de Pago";/*display('kind_of_person')*/?> <i class="text-danger">*</i></label>
                                            <select class="form-control" name="fac_fp" id="fac_fp" required data-required-error="Campo obligatorio.">
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
                                        <div class="col form-group">
                                            <label  class="control_label"><?php echo "Método de Pago";/*display('kind_of_person')*/?> <i class="text-danger">*</i></label>
                                            <select class="form-control" name="fac_mp" id="fac_mp" required data-required-error="Campo obligatorio.">
                                                <option value=""><?php echo display('select_one')?></option>
                                                <option value="PPD"> Pago en parcialidades o diferido</option>
                                                <option value="PUE"> Pago en una sola exhibición</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div> <!-- form-row end.// -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!--========= End CheckOut Area ==========-->
<!-- Push delivery cost to cache by ajax -->

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


    function checkboxEditData(){

        $('#checkbox_customer_save_data').removeAttr('disabled');
        $('#customer_rfc').removeAttr('disabled');
        $('#customer_variant').removeAttr('disabled');

        var customer_variant = $('#customer_variant option:selected').val();
        if (customer_variant == 1) {

            $('#customer_name').removeAttr('disabled');
            $('#customer_first_lastname').removeAttr('disabled');
            $('#customer_secon_lastname').removeAttr('disabled');


        }else if (customer_variant == 2){
            $('#customer_social_reason').removeAttr('disabled');
        }

    }

</script>



<script type="text/javascript">
    $(document).ready(function(){
        // Toolbar extra buttons
        var btnFinish = $('<button></button>').text('Facturar').addClass('btn submit_btn').prop('disabled',true).on('click', function(){
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


        var btnCancel = $('<button></button>').text('Cancelar').addClass('btn btn_cancel').on('click', function(){
            $('#wizard_form').smartWizard("reset");
            $('#myForm').find("input, textarea").val("");
        });

        var btnFacOtherMoment = $('<button></button>').text('Facturar en otro momento').addClass('btn btn-danger btn-block mr-5').on('click', function(){
            window.location.href = "<?php echo base_url(); ?>";
        });

        // Smart Wizard
        $('#wizard_form').smartWizard({
            selected: 0,
            // disabledSteps:[1,2],
            cycleSteps:false,
            theme: 'dots',
            transitionEffect:'fade',
            toolbarSettings: {toolbarPosition: 'bottom',
                toolbarExtraButtons: [btnFacOtherMoment, btnFinish, btnCancel]
            },
            anchorSettings: {
                markDoneStep: true, // add done css
                markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
            }
        });

        $("#wizard_form").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {

            if(stepNumber==0)
            {

                var selectForm = $("#select-step-0");
                var formRow1 = $("#form-row1-step-0");
                var formRow2 = $("#form-row2-step-0");
                if(stepDirection === 'forward' && selectForm && formRow1 && formRow2){
                    selectForm.validator('validate');
                    formRow1.validator('validate');
                    formRow2.validator('validate');

                    var selectFormError = selectForm.children('.has-error');
                    var formRow1Error = formRow1.children('.has-error');
                    var formRow2Error = formRow2.children('.has-error');

                    if(selectFormError.length > 0 || formRow1Error.length >0 || formRow2Error.length >0){
                        // Form validation failed
                        return false;
                    }
                }
                return true;
            }
            return true

        });

        $("#wizard_form").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
            console.log(stepNumber);
            if(stepNumber == 1){
                $('.submit_btn').removeAttr('disabled');
                $('.submit_btn').addClass('facturar-activado');
                $('.sw-btn-next').css({'display': 'none'});
            }else{
                $('.submit_btn').prop('disabled',true);
                $('.submit_btn').removeClass('facturar-activado');
                $('.sw-btn-next').css({'display': 'inline-block'});
            }
        });

        $('.sw-btn-next').html('Siguiente');
        $('.sw-btn-prev').html('Anterior');


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
    /*var $radios = $('input:radio[name=dipe-datos-envio]');
     if($radios.length > 0) {
     $($radios[0]).prop('checked', true);
     }*/

    $('input:radio[name=dipe-datos-facturacion]').click(function(){
        var datos = $('input:radio[name=dipe-datos-facturacion]:checked').val().split('/');

        $('#customer_name').val(datos[0]);
        $('#customer_first_lastname').val(datos[1]);
        $('#customer_secon_lastname').val(datos[2]);
        $('#customer_variant').val(datos[3]);
        $('#customer_rfc').val(datos[4]);
        $('#customer_social_reason').val(datos[5]);

        $('#checkbox_customer_save_data').prop('disabled',true);
        $('#group_edit_data').css({'display':'block'});

        $('#customer_rfc').prop('disabled',true);
        $('#customer_variant').prop('disabled',true);

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

            $('#customer_name').prop('disabled',true);
            $('#customer_first_lastname').prop('disabled',true);
            $('#customer_secon_lastname').prop('disabled',true);


        }else if (customer_variant == 2){
            $('#groupCustomerName').css({'display': 'none'});
            $('#groupCustomerFirstLastName').css({'display': 'none'});
            $('#groupCustomerSeconLastName').css({'display': 'none'});
            $('#groupCustomerSocialReason').css({'display': 'block'});

            $('#customer_name').removeAttr("required");
            $('#customer_first_lastname').removeAttr("required");
            $('#customer_secon_lastname').removeAttr("required");
            $('#customer_social_reason').prop('required',true);

            $('#customer_social_reason').prop('disabled',true);
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



        var collapse = 'collapse-'+datos[6]

        console.log(datos);

        $('div[name=dipe-datos-facturacion-collapse]').removeClass('out show');
        $('#'+collapse).addClass('out show');
    });

</script>

<script type="text/javascript">
    $('#groupCustomerName').css({'display': 'none'});
    $('#groupCustomerFirstLastName').css({'display': 'none'});
    $('#groupCustomerSeconLastName').css({'display': 'none'});
    $('#groupCustomerSocialReason').css({'display': 'none'});

    $('#group_edit_data').css({'display':'none'});

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