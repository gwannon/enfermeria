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
<div class="col">
    <h2><?php _e("Login", "enfermeria"); ?></h2>
    <p><?php _e("No estás logeado", "enfermeria"); ?></p>
    <?php echo wp_login_form(); ?>
</div>
<div class="col">
    <h2><?php _e("Registro", "enfermeria"); ?></h2>
    <p><?php _e("Si deseas registrarte rellena este formulario. Estudiaremos tu solicitud y veremos si aceptamos tu solicitud.", "enfermeria"); ?></p>
    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
        <input type="hidden" name="action" value="custom_registration"> 
        <input type="text" name="firstname" placeholder="<?php _e("Nombre", "enfermeria"); ?>" required/><br/>
        <input type="text" name="lastname" placeholder="<?php _e("Apellidos", "enfermeria"); ?>" required/><br/>
        <input type="text" name="email" placeholder="<?php _e("Email", "enfermeria"); ?>" required/><br/>
        <input type="password" name="password" placeholder="<?php _e("Contraseña", "enfermeria"); ?>" required /><br/>
        <input type="submit" value="<?php _e("Registro", "enfermeria"); ?>" />
    </form>
</div>