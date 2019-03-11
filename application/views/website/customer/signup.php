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
            <div class="col-md-9 col-sm-12 col-lg-6">

                <div class="card">
                    <header class="card-header">
                        <a href="<?php echo base_url().'login'?>" class="float-right btn btn-outline-primary mt-1">Accede</a>
                        <h4 class="card-title mt-2">Crea tu cuenta</h4>
                    </header>
                    <article class="card-body">
                        <form action="<?php echo base_url('user_signup')?>" method="post" data-toggle="validator" data-disable="false">
                            <div class="form-row">
                                <div class="col form-group">
                                    <label>Nombre</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="" name="first_name" required="" data-required-error="Campo obligatorio.">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div> <!-- form-group end.// -->
                                <div class="help-block with-errors"></div>
                                <div class="col form-group">
                                    <label>Apellidos</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="" name="last_name" required="" data-required-error="Campo obligatorio.">
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div> <!-- form-group end.// -->
                                <div class="help-block with-errors"></div>
                            </div> <!-- form-row end.// -->
                            <div class="form-group">
                                <label>Correo electrónico</label>
                                <input type="email" class="form-control" placeholder="" name="email" required="" data-required-error="Campo obligatorio." data-type-error="Dirección de correo inválida">
                                <div class="help-block with-errors"></div>
                                <!--<small class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                            </div> <!-- form-group end.// -->

                            <div class="form-group">
                                <label>Contraseña</label>
                                <input class="form-control" type="password" name="password" required="" data-required-error="Campo obligatorio.">
                                <div class="help-block with-errors"></div>
                            </div> <!-- form-group end.// -->
                            <div class="form-group">
                                <button type="submit" class="btn dipe-btn-warning btn-warning btn-block"> Registrar  </button>
                            </div> <!-- form-group// -->
                            <!--<small class="text-muted">By clicking the 'Sign Up' button, you confirm that you accept our <br> Terms of use and Privacy Policy.</small>-->
                        </form>
                    </article> <!-- card-body end .// -->
                    <div class="border-top card-body text-center">¿Ya tienes una cuenta? <a href="<?php echo base_url().'login'?>">Accede</a></div>
                </div> <!-- card.// -->


            </div>
        </div>
    </div>




    </div><!-- container // -->
</section>
<!-- ========================= SECTION CONTENT .END// ========================= -->