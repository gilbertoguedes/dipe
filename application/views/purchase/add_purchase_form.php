<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!-- Payment type select by js start-->
<style>
    #store_hide
    {
        display:none;
    }   
</style>
<script type="text/javascript">
    function bank_info_show(payment_type)
    {
        if(payment_type.value == "1"){
            document.getElementById("store_hide").style.display="none";
            document.getElementById("wearhouse_hide").style.display="block";  
        }else{
            document.getElementById("wearhouse_hide").style.display="none"; 
            document.getElementById("store_hide").style.display="block"; 
        }
    }
</script>
<!-- Payment type select by js end-->

<!-- Add New Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('purchase') ?></h1>
            <small><?php echo display('add_purchase') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active"><?php echo display('add_purchase') ?></li>
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
                  <a href="<?php echo base_url('Cpurchase/manage_purchase')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_purchase')?></a>  
                </div>
            </div>
        </div>

        <!-- Add New Purchase -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_purchase') ?></h4>
                        </div>
                    </div>

                    <div class="panel-body">
                    <?php echo form_open_multipart('Cpurchase/insert_purchase',array('class' => 'form-vertical', 'id' => 'validate','name' => 'insert_purchase'))?>
                        
                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="supplier_sss" class="col-sm-4 col-form-label"><?php echo display('text_supplier') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-5">
                                        <select name="supplier_id" id="supplier_id" class="form-control " required=""> 
                                            <option value=""><?php echo display('select_one') ?></option>
                                            {all_supplier}
                                            <option value="{supplier_id}">{supplier_name}</option>
                                            {/all_supplier}
                                        </select>
                                    </div>
                                   <?php if ($this->session->userdata('user_type') != '4') { ?>
                                    <div class="col-sm-3">
                                        <a href="<?php echo base_url('Csupplier'); ?>"><?php echo display('add_supplier') ?></a>
                                    </div>
                                   <?php } ?>
                                </div> 
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <?php $date = date('m-d-Y'); ?>
                                        <input type="text" tabindex="3" class="form-control datepicker" name="purchase_date" value="<?php echo $date; ?>" id="date" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="invoice_no" class="col-sm-4 col-form-label"><?php echo display('order_no') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" class="form-control" name="invoice_no" placeholder="<?php echo display('order_no') ?>" id="invoice_no" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label"><?php echo display('comments') ?>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="1" id="adress" name="purchase_details" placeholder=" <?php echo display('comments') ?>" rows="1"></textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <?php if ($this->session->userdata('user_type') != '4') { ?>
                        <div class="row">
                            <!--<div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="purchase_to" class="col-sm-4 col-form-label"><?php echo display('asing_to') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="purchase_to" id="purchase_to" class="form-control" required="" onchange="bank_info_show(this)"> 
                                            <option value="1"><?php echo display('text_wearhouse')?></option>
                                            <option value="2"><?php echo display('text_store')?></option>
                                        </select>
                                    </div>
                                </div> 
                            </div>-->
                            <!--<div class="col-sm-6" id="wearhouse_hide">
                                <div class="form-group row">
                                    <label for="wearhouse_id" class="col-sm-4 col-form-label"><?php echo display('text_wearhouse') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="wearhouse_id" id="wearhouse_id" class="form-control" required=""> 
                                            <option value=""></option> 
                                            {wearhouse_list}
                                            <option value="{wearhouse_id}">{wearhouse_name}</option>
                                            {/wearhouse_list}
                                        </select>
                                    </div>
                                </div>
                            </div>-->

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="store_id" class="col-sm-4 col-form-label"><?php echo display('text_store') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="store_id" id="store_id" class="form-control" required="" style="width: 100%">
                                            <option value=""></option> 
                                            {store_list}
                                            <option value="{store_id}">{store_name}</option>
                                            {/store_list}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="store_id" class="col-sm-4 col-form-label"><?php echo display('text_store') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="store_id" id="store_id" class="form-control" required="" style="width: 100%">
                                            <?php foreach($store_list as $sto){ ?>
                                                <?php if($this->session->userdata('store_id')==$sto['store_id']){?>
                                                <option value="<?php echo $sto['store_id'] ?>"><?php echo $sto['store_name'] ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="purchaseTable">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('product_name') ?> <i class="text-danger">*</i></th>
                                        <!--<th class="text-center" width="130"><?php echo display('variant') ?> <i class="text-danger">*</i></th>-->
                                        <th class="text-center"><?php echo display('available_quantity') ?> </th>
                                        <th class="text-center"><?php echo display('add_quantity') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('rate') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('total') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('delete') ?> </th>
                                    </tr>
                                </thead>
                                <tbody id="addPurchaseItem">
                                    <tr>
                                        <td>
                                            <input type="text" name="product_name" required class="form-control product_name productSelection" onkeyup="product_pur_or_list(1);" placeholder="<?php echo display('product_name') ?>" id="product_name_1" tabindex="5" >

                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>

                                            <input type="hidden" class="sl" value="1">
                                        </td>

                                        <!--<td class="text-center">
                                            <select name="variant_id[]" id="variant_id_1" class="form-control variant_id" required="" style="width: 100%">
                                                <option value=""></option>
                                            </select>
                                        </td>-->

                                        <td class="text-right">
                                            <input type="number" id="avl_qntt_1" class="form-control text-right" placeholder="0" readonly />
                                        </td>

                                        <td class="text-right">
                                            <input type="number" name="product_quantity[]" id="total_qntt_1" onkeyup="calculate_add_purchase('1')" onchange="calculate_add_purchase('1')" class="form-control text-right" placeholder="0" min="0" required="" />
                                        </td>
                                        <td>
                                            <input type="number" name="product_rate[]"  id="price_item_1" class="price_item1 text-right form-control" placeholder="0.00" onkeyup="calculate_add_purchase('1')" onchange="calculate_add_purchase('1')" min="0"/>
                                        </td>
                                        <td class="text-right">
                                            <input class="total_price text-right form-control" type="text" name="total_price[]" id="total_price_1" placeholder="0.00" readonly="readonly" />
                                        </td>
                                        <td>
                                            <button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">
                                            <input type="button" id="add-invoice-item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseOrderField('addPurchaseItem');" value="<?php echo display('add_new_product') ?>" />

                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
                                        </td>
                                        <td style="text-align:right;"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td class="text-right">
                                            <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" placeholder ="0.00" readonly="readonly" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add-purchase" class="btn btn-primary btn-large" name="add-purchase" value="<?php echo display('submit') ?>" />
                                <!--<input type="submit" value="<?php echo display('submit_and_add_another') ?>" name="add-purchase-another" class="btn btn-large btn-success" id="add-purchase-another">-->
                            </div>
                        </div>
                    <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add New Purchase End -->

<!-- Product purchase list -->
<script type="text/javascript">

    //Product purchase or list
    function product_pur_or_list(sl) {

        var supplier_id  = $('#supplier_id').val();
        var product_name = $('#product_name_'+sl).val();

        //Supplier id existing check
        if ( supplier_id == 0) {
            alert('<?php echo display('please_select_supplier')?>');
            $('#product_name_'+sl).val('');
            return false;
        }

        // Auto complete ajax
        var options = {
                minLength: 0,
                source: function( request, response ) {
                $.ajax( {
                    url: "<?php echo base_url('Cpurchase/product_search_by_supplier')?>",
                    method: 'post',
                    dataType: "json",
                    data: {
                        term: request.term,
                        supplier_id:$('#supplier_id').val(),
                        product_name:product_name,
                        store_id:$('#store_id').val()
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            focus: function( event, ui ) {
                $(this).val(ui.item.label);
                return false;
            },
            select: function( event, ui ) {
                $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
                var sl          = $(this).parent().parent().find(".sl").val(); 
                var id          = ui.item.value;
                var dataString  = 'product_id='+ id;
                var avl_qntt    = 'avl_qntt_'+sl;
                var price_item  = 'price_item_'+sl;
                var variant_id  = 'variant_id_'+sl;
             
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('Cpurchase/retrieve_product_data')?>",
                    data: dataString,
                    cache: false,
                    success: function(data)
                    {
                        obj = JSON.parse(data);
                        $('#'+price_item).val(obj.supplier_price);
                        $('#'+avl_qntt).val(obj.total_product);
                        $('#'+variant_id).html(obj.variant);
                    } 
                });

                $(this).unbind("change");
                return false;
           }
        }
        $('body').on('keydown.autocomplete', '.product_name', function() {
           $(this).autocomplete(options);
        });
    }
</script>


<!-- JS -->
<script type="text/javascript">

    // Counts and limit for purchase order
    var count = 2;
    var limits = 500;

    //Add Purchase Order Field
    function addPurchaseOrderField(divName){

        if (count == limits)  {
            alert("You have reached the limit of adding " + count + " inputs");
        }else{
            var newdiv = document.createElement('tr');
            var tabin  = "product_name_"+count;

            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });

            newdiv.innerHTML ='<td><input type="text" name="product_name" required class="form-control product_name productSelection" onkeyup="product_pur_or_list('+count+');" placeholder="<?php echo display('product_name') ?>" id="product_name_'+count+'" tabindex="5" ><input type="hidden" class="autocomplete_hidden_value product_id_'+count+'" name="product_id[]" id="SchoolHiddenId"/><input type="hidden" class="sl" value="'+count+'"></td><td class="text-right"><input type="number" id="avl_qntt_'+count+'" class="form-control text-right" placeholder="0" readonly /></td><td class="text-right"><input type="number" name="product_quantity[]" id="total_qntt_'+count+'" onkeyup="calculate_add_purchase('+count+')" onchange="calculate_add_purchase('+count+')"  class="form-control text-right" placeholder="0" min="0" required/></td><td><input type="number" name="product_rate[]" id="price_item_'+count+'" class="price_item1 text-right form-control" placeholder="0.00" min="0" onkeyup="calculate_add_purchase('+count+')" onchange="calculate_add_purchase('+count+')"/></td><td class="text-right"><input class="total_price text-right form-control" type="text" name="total_price[]" id="total_price_'+count+'" placeholder="0.00" readonly="readonly" /> </td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?></button></td>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            count++;

            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });
        }
    }

    //Calculate store product
    function calculate_add_purchase(sl) {

        var e = 0;
        var gr_tot = 0;
        var total_qntt   = $("#total_qntt_"+sl).val();
        var price_item   = $("#price_item_"+sl).val();
        var total_price  = total_qntt * price_item;

        $("#total_price_"+sl).val(total_price.toFixed(2));

        //Total Price
        $(".total_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });

        $("#grandTotal").val(gr_tot.toFixed(2,2));
    }

    //Select stock by product and variant id
    $('body').on('change', '.variant_id', function() {

        var sl            = $(this).parent().parent().find(".sl").val();
        var product_id    = $('.product_id_'+sl).val();
        var avl_qntt      = $('#avl_qntt_'+sl).val();
        var purchase_to   = $('#purchase_to').val();
        var wearhouse_id  = $('#wearhouse_id').val();
        var store_id      = $('#store_id').val();
        var variant_id    = $(this).val();

        if (purchase_to == 1) {
            if (wearhouse_id == 0) {
                alert('<?php echo display('please_select_wearhouse')?>');
                return false;
            }
        }

        if (purchase_to == 2) {
            if (store_id == 0) {
                alert('<?php echo display('please_select_store')?>');
                return false;
            }
        }

        $.ajax({
            type: "post",
            async: false,
            url: '<?php echo base_url('Cpurchase/wearhouse_available_stock')?>',
            data: {product_id: product_id,variant_id:variant_id,purchase_to:purchase_to,wearhouse_id:wearhouse_id,store_id:store_id},
            success: function(data) {
                if (data) {
                    $('#avl_qntt_'+sl).val(data);
                }
            },
            error: function() {
                alert('Request Failed, Please check your code and try again!');
            }
        });
    }); 

    //Delete a row from purchase table
    function deleteRow(t) {
        var a = $("#purchaseTable > tbody > tr").length;
        if (1 == a) {
            alert("There only one row you can't delete."); 
            return false;
        }else {
            var e = t.parentNode.parentNode;
            e.parentNode.removeChild(e);
            calculate_add_purchase();
        
        }
        calculate_add_purchase();
        $('#item-number').html('0');
        $(".itemNumber>tr").each(function(i){
            $('#item-number').html(i+1);
            $('.item_bill').html(i+1);
        });
    }
</script>