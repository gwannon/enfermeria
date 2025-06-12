<?php if(isset($_GET['register']) && $_GET['register'] == 'ok') { ?>
    <div class="col-12">
        <div class="alert alert-success" role="alert">
            <?php _e("Registro realizado con éxito.", "enfermeria"); ?>
        </div>
    </div>
<?php } else if(isset($_GET['logout']) && $_GET['logout'] == 'ok') { ?>
    <div class="col-12">
        <div class="alert alert-success" role="alert">
            <?php _e("Desconexión realizado con éxito.", "enfermeria"); ?>
        </div>
    </div>
<?php } ?>
<div class="col border m-1 p-3">
    <h2><?php _e("Acceso", "enfermeria"); ?></h2>
    <p><?php _e("Si ya tienes usuario y contraseña, introdúcelos en el siguiente formulario para poder acceder.", "enfermeria"); ?></p>
    <?php echo enfermeria_wp_login_form(); ?>
</div>
<div class="col border m-1 p-3">
    <h2><?php _e("Registro", "enfermeria"); ?></h2>
    <p><?php _e("Si deseas registrarte rellena este formulario. Estudiaremos tu solicitud y veremos si aceptamos tu solicitud.", "enfermeria"); ?></p>
    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
        <input type="hidden" name="action" value="custom_registration"> 
        <p><label for="name_register"><?php _e("Nombre", "enfermeria"); ?></label>
        <input class="form-control" id="name_register" type="text" name="firstname" autocomplete="given-name" placeholder="<?php _e("Nombre", "enfermeria"); ?>" required/></p>
        <p><label for="lastname_register"><?php _e("Apellidos", "enfermeria"); ?></label>
        <input class="form-control" id="lastname_register" type="text" name="lastname" autocomplete="family-name" placeholder="<?php _e("Apellidos", "enfermeria"); ?>" required/></p>
        <p><label for="email_register"><?php _e("Email", "enfermeria"); ?></label>
        <input class="form-control" id="email_register" type="email" pattern=".+@euskadi\.eus" name="email" placeholder="<?php _e("nombre@euskadi.eus", "enfermeria"); ?>" autocomplete="off" required/></p>
        <p><label for="password_register"><?php _e("Contraseña", "enfermeria"); ?></label>
        <input class="form-control" id="password_register" type="text" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,100}$" name="password" placeholder="<?php _e("Mínimo 8 caracteres, mayúsculas, minúsculas y números", "enfermeria"); ?>" autocomplete="off" required /></p>

         <input class="btn btn-primary" type="submit" value="<?php _e("Registro", "enfermeria"); ?>" />
    </form>
</div>