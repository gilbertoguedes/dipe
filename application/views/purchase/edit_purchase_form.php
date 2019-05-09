<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Payment type select by js start-->
<style>
    <?php
    if ($wearhouse_id) {
        echo "#store_hide{display:none;}";
    }else{
        echo "#wearhouse_hide{display:none;}";
    }
    ?>
</style>
<script type="text/javascript">
    function bank_info_show(payment_type)
    {
        if(payment_type.value == "1"){
            document.getElementById("store_hide").style.display="none";
            document.getElementById("wearhouse_hide").style.display="block";  
            $('#store option:selected').removeAttr('selected');
        }else{
            document.getElementById("wearhouse_hide").style.display="none"; 
            document.getElementById("store_hide").style.display="block"; 
            $('#wearhouse option:selected').removeAttr('selected');
        }
    }
</script>
<!-- Payment type select by js end-->

<!-- Edit Purchase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('purchase') ?></h1>
            <small><?php echo display('purchase_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('purchase') ?></a></li>
                <li class="active"><?php echo display('purchase_edit') ?></li>
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

        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('purchase_edit') ?></h4>
                        </div>
                    </div>
                   <?php echo form_open_multipart('Cpurchase/purchase_update',array('class' => 'form-vertical', 'id' => 'validate'))?>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="description" class="col-sm-3 col-form-label"><?php echo display('text_supplier') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-6">
                                        <!-- js-example-basic-single -->
                                        <select name="supplier_id" id="supplier_id" class="form-control " required=""> 
                                            {supplier_list}
                                            <option value="{supplier_id}">{supplier_name}</option>
                                            {/supplier_list}
                                            {supplier_selected}
                                            <option selected value="{supplier_id}">{supplier_name} </option>
                                            {/supplier_selected}
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
                                    <label for="product_name" class="col-sm-4 col-form-label"><?php echo display('purchase_date') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input type="text" tabindex="3" class="form-control datepicker" name="purchase_date" value="{purchase_date}" required />
                                        <input type="hidden" name="purchase_id" value="{purchase_id}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="product_name" class="col-sm-3 col-form-label"><?php echo display('order_no') ?> <i class="text-danger">*</i></label>
                                    <div class="col-sm-9">
                                        <input type="text" tabindex="3" class="form-control" name="invoice_no" placeholder="<?php echo display('order_no') ?>" required value="{invoice_no}" />
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                               <div class="form-group row">
                                    <label for="adress" class="col-sm-4 col-form-label"><?php echo display('comments') ?></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" tabindex="1" id="adress" name="purchase_details" placeholder=" <?php echo display('comments') ?>">{purchase_details}</textarea>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <?php if ($this->session->userdata('user_type') != '4') { ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="store_id" class="col-sm-4 col-form-label"><?php echo display('text_store') ?>
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="store_id" id="store_id" class="form-control" required="" style="width: 100%">
                                            <option value=""></option> 
                                            <?php
                                            if ($store_list) {
                                                foreach ($store_list as $store) {
                                            ?>
                                            <option value="<?php echo $store['store_id']?>" <?php if ($store['store_id'] == $store_id) {echo "selected";}?>><?php echo $store['store_name']?></option>
                                                   <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }else{ ?>
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
                                        <th class="text-center"><?php echo display('available_quantity') ?> </th>
                                        <th class="text-center"><?php echo display('add_quantity') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('rate') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('total') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('action') ?> </th>
                                    </tr>
                                </thead>
                				<tbody id="addPurchaseItem">
                                <?php
                                if($purchase_info){
                                    foreach ($purchase_info as $purchase) {

                                        //Stock available qty variant wise
                                        $this->db->select('SUM(a.quantity) as total_purchase');
                                        $this->db->from('product_purchase_details a');
                                        $this->db->where('a.product_id',$purchase['product_id']);
                                        if (!empty($purchase['wearhouse_id'])) {
                                        $this->db->where('a.wearhouse_id',$purchase['wearhouse_id']);
                                        }else{
                                        $this->db->where('a.store_id',$purchase['store_id']);
                                        }
                                        $total_purchase = $this->db->get()->row();

                                        //Total purchase
                                        $this->db->select('SUM(b.quantity) as total_sale');
                                        $this->db->from('invoice_details b');
                                        $this->db->where('b.product_id',$purchase['product_id']);
                                        
                                        if (!empty($purchase['wearhouse_id'])) {
                                        $this->db->where('b.status',1);
                                        }else{
                                        $this->db->where('b.store_id',$purchase['store_id']);
                                        }
                                        $total_sale = $this->db->get()->row();

                                        //Variant for per product
                                        /*$this->db->select('a.variants');
                                        $this->db->from('product_information a');
                                        $this->db->where(array('a.product_id' => $purchase['product_id'],'a.status' => 1)); 
                                        $product_information = $this->db->get()->row();
                                        $exploded = explode(',',$product_information->variants);*/
                                ?>
        							<tr>
        								<td>
                                            <input type="text" name="product_name" required class="form-control product_name productSelection" onkeyup="product_pur_or_list(<?php echo $purchase['sl']?>);" placeholder="<?php echo display('product_name') ?>" id="product_name_<?php echo $purchase['sl']?>" tabindex="5" value="<?php echo $purchase['product_name']?>">

                                            <input type="hidden" class="autocomplete_hidden_value product_id_<?php echo $purchase['sl']?>" name="product_id[]" id="" value="<?php echo $purchase['product_id']?>" />

                                            <input type="hidden" class="sl" value="<?php echo $purchase['sl']?>">
                                        </td>
                                        
                                        <td class="text-right">
                                            <input type="number" id="avl_qntt_<?php echo $purchase['sl']?>" class="form-control text-right" placeholder="0" readonly value="<?php echo $total_purchase->total_purchase - $total_sale->total_sale;?>"/>
                                        </td>  

                                        <td class="text-right">
                                            <input type="number" name="product_quantity[]" onkeyup="calculate_add_purchase(<?php echo $purchase['sl']?>);" onchange="calculate_add_purchase(<?php echo $purchase['sl']?>);" id="total_qntt_<?php echo $purchase['sl']?>"  class="form-control text-right" placeholder="0" value="<?php echo $purchase['quantity']?>" min="0" required/>
                                        </td>
                                        <td>
                                            <input type="number" name="product_rate[]" value="<?php echo $purchase['rate']?>"  id="price_item_<?php echo $purchase['sl']?>" class="price_item<?php echo $purchase['sl']?> text-right form-control" onkeyup="calculate_add_purchase(<?php echo $purchase['sl']?>);" onchange="calculate_add_purchase(<?php echo $purchase['sl']?>);" placeholder="0.00" min="0" required/>
                                        </td>
                                        <td class="text-right">
                                            <input class="total_price text-right form-control" value="<?php echo $purchase['total_amount']?>" type="text" name="total_price[]" id="total_price_<?php echo $purchase['sl']?>" readonly="readonly" />
                                        
        									<input type="hidden" name="purchase_detail_id[]" value="<?php echo $purchase['purchase_detail_id']?>"/>
        								</td>
                                        <td>
                                            <button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?></button>
                                        </td>
        							</tr>
                                <?php
                                    }
                                }
                                ?>
        						</tbody>
        						<tfoot>
        							<tr>
        								<td colspan="4">

                                            <input type="button" id="add-invoice-item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseOrderField('addPurchaseProduct');" value="<?php echo display('add_new_product') ?>" />

                                            <!--<input type="submit" id="add-purchase" class="btn btn-success btn-large" name="add-purchase" value="<?php echo display('save_changes') ?>" />-->
                                            <input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>                        
                                        </td>
        								<td style="text-align:right;" ><b><?php echo display('grand_total') ?>:</b></td>
        								<td class="text-right">
                                            <input type="text" id="grandTotal" value="{grand_total}" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly" />
        								</td>
        							</tr>
        						</tfoot>
                            </table>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add-purchase" class="btn btn-success btn-large" name="add-purchase" value="<?php echo display('save_changes') ?>" />
                                <!--<input type="submit" value="<?php echo display('submit_and_add_another') ?>" name="add-purchase-another" class="btn btn-large btn-success" id="add-purchase-another">-->
                            </div>
                        </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Edit Purchase End -->


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
                    product_name:product_name
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
    var rows = $('#purchaseTable tbody tr').length;
    var count = rows + 1;
    var limits = 500;

    //Add Purchase Order Field
    function addPurchaseOrderField(divName){

        if (count == limits)  {
            alert("You have reached the limit of adding " + count + " inputs");
        }
        else{
            var newdiv = document.createElement('tr');
            var tabin="product_name_"+count;

            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });

            newdiv.innerHTML ='<td><input type="text" name="product_name" required class="form-control product_name productSelection" onkeyup="product_pur_or_list('+count+');" placeholder="<?php echo display('product_name') ?>" id="product_name_'+count+'" tabindex="5" ><input type="hidden" class="autocomplete_hidden_value product_id_'+count+'" name="product_id[]" id="SchoolHiddenId"/><input type="hidden" class="sl" value="'+count+'"></td><td class="text-right"><input type="number" id="avl_qntt_'+count+'" class="form-control text-right" placeholder="0" readonly /></td><td class="text-right"><input type="number" name="product_quantity[]" id="total_qntt_'+count+'" onkeyup="calculate_add_purchase('+count+')"  class="form-control text-right" placeholder="0" min="0" required/></td><td><input type="number" name="product_rate[]"  id="price_item_'+count+'" class="price_item1 text-right form-control" placeholder="0.00" min="0"/></td><td class="text-right"><input class="total_price text-right form-control" type="text" name="total_price[]" id="total_price_'+count+'" placeholder="0.00" readonly="readonly" /> </td><td><button style="text-align: right;" class="btn btn-danger" type="button" value="<?php echo display('delete')?>" onclick="deleteRow(this)"><?php echo display('delete')?></button></td>';
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