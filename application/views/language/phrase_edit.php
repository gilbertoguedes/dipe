<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Add Phrase Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('phrase_edit') ?></h1>
            <small><?php echo display('phrase_edit') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li><a href="#"><?php echo display('language') ?></a></li>
                <li class="active"><?php echo display('phrase_edit') ?><!--Phrase Edit--></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Phrase Edit -->

        <?php
            $message = $this->session->userdata('message');
            if (isset($message)) {
        ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>                    
        </div>
        <?php 
            }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <a href="<?= base_url('Language') ?>" class="btn btn-info"><?php echo display('language_home') ?><!--Language Home--></a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('phrase_edit') ?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <?= form_open('language/addlebel') ?>
                            <table id="" class="table table-bordered table-striped table-hover">
                                <thead> 
                                    <tr>
                                        <th><i class="fa fa-th-list"></i></th>
                                        <th><?php echo display('phrase') ?></th>
                                        <th><?php echo display('label') ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?= form_hidden('language', $language) ?>
                                    <?php if (!empty($phrases)) {?>
                                        <?php $sl = 1 ?>
                                        <?php foreach ($phrases as $value) {?>
                                        <tr class="<?= (empty($value->$language)?"bg-danger":null) ?>">
                                        
                                            <td><?= $this->uri->segment('4')+$sl++ ?></td>
                                            <td><input type="text"  name="phrase[]" value="<?= $value->phrase ?>" class="form-control" readonly></td>
                                            <td><input type="text" onblur="EditLang('<?php echo $value->id;?>')" id="<?php echo $value->id;?>" name="lang[]" value="<?= $value->$language ?>" class="form-control"></td> 
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php echo form_close()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Phrase Edit End -->

<script type="text/javascript">
    function EditLang(id){
        var value = $('#'+id).val();
        var language = '<?php echo $this->uri->segment(3)?>';

        $.ajax({
            url: "<?php echo base_url()?>Language/edit_save_ajax",
            type: 'POST',
            data: {'id':id,'value':value,'language':language}, 
            success: function (data){ 
                toastr.success(data, " ", {
                    "timeOut": "200",
                    "extendedTImeout": "200"
                });   
            },
            error: function (exc){
                toastr.warning("Failed");
            }
        });
    }
</script>




