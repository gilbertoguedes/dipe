<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y-sm dipe-section-content">
    <div class="container">
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
        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-6 col-lg-4">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title text-center mb-4 mt-1">Restablecer Contraseña</h4>
                        <hr>
                        <!--<p class="text-success text-center">Some message goes here</p>-->
                        <form action="<?php echo base_url('do_reset_password')?>" method="post" data-toggle="validator" data-disable="false">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input name="email" required data-required-error="Campo obligatorio." data-type-error="Dirección de correo inválida" class="form-control" placeholder="Correo electrónico" type="email">
                                </div> <!-- input-group.// -->
                                <div class="help-block with-errors"></div>
                            </div> <!-- form-group// -->
                            <div class="form-group">
                                <button type="submit" class="btn dipe-btn-warning btn-warning btn-block"> Enviar  </button>
                            </div> <!-- form-group// -->
                        </form>
                    </article>
                    <div class="dipe-red-line"></div>
                    <div class="dipe-blue-line"></div>
                    <div class="dipe-yellow-line"></div>
                </div> <!-- card.// -->
            </div>
        </div>
    </div>




    </div><!-- container // -->
</section>
<!-- ========================= SECTION CONTENT .END// ========================= -->