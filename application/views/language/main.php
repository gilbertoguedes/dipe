<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Manage Language Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('language')?><!--Manage Language--></h1>
            <small><?php echo display('manage_your_language')?><!--Manage your language--></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('software_settings') ?></a></li>
                <li class="active"><?php echo display('language')?><!--Manage Language--></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Manage Language -->

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
                <a href="<?= base_url('Language/phrase') ?>" class="btn btn-info"><?php echo display('add_phrase')?><!--Add Phrase--></a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('manage_your_language')?></h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTableExample2" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr>
                                        <td colspan="3">
                                            <?= form_open('language/addlanguage', ' class="form-inline" ') ?> 
                                                <div class="form-group">
                                                    <label class="sr-only" for="addLanguage"><?php echo display('manage_your_language')?> <!--Language Name--></label>
                                                    <input name="language" type="text" class="form-control" id="addLanguage" placeholder="<?php echo display('language_name')?>">
                                                </div>
                                                  
                                                <button type="submit" class="btn btn-primary"><?php echo display('save')?></button>
                                            <?= form_close(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><i class="fa fa-th-list"></i></th>
                                        <th><?php echo display('language')?></th>
                                        <th><i class="fa fa-cogs"></i></th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php if (!empty($languages)) {?>
                                        <?php $sl = 1 ?>
                                        <?php foreach ($languages as $key => $language) {?>
                                        <tr>
                                            <td><?= $sl++ ?></td>
                                            <td><?= $language ?></td>
                                            <td><a href="<?= base_url("Language/editPhrase/$key") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>  
                                            </td> 
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Language End -->



