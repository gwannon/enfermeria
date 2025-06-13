<?php if(isset($_GET['logout']) && $_GET['logout'] == 'ok') { ?>
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

    <?php if (isset($_POST['registration']) && $_POST['registration'] == 'new_registration') {

        $errores = [];
        $registeruser = sanitize_title($_POST['email']); // potentially sanitize these
        $registerpass = $_POST['password']; // potentially sanitize these
        $registeremail = strtolower($_POST['email']); // potentially sanitize these
        $registerfirstname = $_POST['firstname'];
        $registerlastname = $_POST['lastname'];

        if($registerfirstname == '') $errores[] = __("Debes rellenar el campo «Nombre».", "enfermeria");
        if($registerlastname == '') $errores[] = __("Debes rellenar el campo «Apellidos».", "enfermeria");
        if(!is_email($registeremail) || !preg_match("/.+@euskadi\.eus/", $registeremail)) $errores[] = __("El email no tiene un formato adecuado. Solo se acepta correos de «@euskadi.eus».", "enfermeria");
        if(email_exists($registeremail)) $errores[] = __("El email ya existe en nuestra base de datos. Usa otra dirección de correo.", "enfermeria");
        if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,100}$/", $registerpass)) $errores[] = __("La contraseña no tiene un formato adecuado. Debe tener un mínimo 8 caracteres, mayúsculas, minúsculas y números.", "enfermeria");

        if (count($errores) == 0) {        
            $user_id = wp_create_user( $registeruser, $registerpass, $registeremail ); // this creates the new user and returns the ID

            if($user_id){ // if the user exists/if creating was successful.
                $user = new WP_User( $user_id ); // load the new user

                $userdata = array(
                    'ID' => $user_id,
                    'first_name' => $registerfirstname,
                    'last_name' => $registerlastname,
                );
                wp_update_user( $userdata );

                $user->set_role('subscriber'); // give the new user a role, in this case a subscriber

                $display_name = get_the_author_meta('first_name', $user_id)." ".get_the_author_meta('last_name', $user_id);

                wp_update_user( array ('ID' => $user_id, 'display_name' => $display_name)); ?>
                <div class="col-12">
                    <div class="alert alert-success" role="alert">
                        <?php _e("Registro realizado con éxito. Recibirás un email cuando aprobemos tu candidatura.", "enfermeria"); ?>
                    </div>
                </div>
                <?php 

                //Mandamos mensaje de aviso
                $headers = array('Content-Type: text/html; charset=UTF-8');
                $subject = sprintf(__("Nuevo usuario %s", "enfermeria"), $user->display_name);
                $edit_link = get_admin_url()."/user-edit.php?user_id=".$user_id;
                $text = sprintf(__("<a href='%s'>Aprobar usuario</a><br/><b>Nombre:</b> %s<br/><b>Email:</b> %s", "enfermeria"), $edit_link, $display_name, $user->user_email); 
                $admins = explode(",", EMAILS_AVISO);
                foreach ($admins as $admin_email) { 
                    if(isset($attachment) && $attachment != '') wp_mail($admin_email, $subject, $text."<br>CON ADJUNTO", $headers, get_attached_file($attachment));
                    else wp_mail($admin_email, $subject, $text, $headers);
                }

                unset($registerfirstname);
                unset($registerlastname);
                unset($registeremail);
                unset($registerpass);
            }
        } else { ?>
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <ul>
                     <?php foreach($errores as $error) {
                        echo "<li>".$error."</li>\n";
                     } ?>
                    </ul>
                </div>
            </div>
        <?php }
    } ?>

    <form method="post">
        <input type="hidden" name="registration" value="new_registration"> 
        <p><label for="name_register"><?php _e("Nombre", "enfermeria"); ?></label>
        <input class="form-control" id="name_register" type="text" name="firstname" autocomplete="given-name" placeholder="<?php _e("Nombre", "enfermeria"); ?>"<?php echo (isset($registerfirstname) ? ' value="'.$registerfirstname.'"' : ''); ?> required/></p>
        <p><label for="lastname_register"><?php _e("Apellidos", "enfermeria"); ?></label>
        <input class="form-control" id="lastname_register" type="text" name="lastname" autocomplete="family-name" placeholder="<?php _e("Apellidos", "enfermeria"); ?>"<?php echo (isset($registerlastname) ? ' value="'.$registerlastname.'"' : ''); ?> required /></p>
        <p><label for="email_register"><?php _e("Email", "enfermeria"); ?></label>
        <input class="form-control" id="email_register" type="email" pattern=".+@euskadi\.eus" name="email" placeholder="<?php _e("nombre@euskadi.eus", "enfermeria"); ?>" autocomplete="off"<?php echo (isset($registeremail) ? ' value="'.$registeremail.'"' : ''); ?> required /></p>
        <p><label for="password_register"><?php _e("Contraseña", "enfermeria"); ?></label>
        <input class="form-control" id="password_register" type="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,100}$" name="password" placeholder="<?php _e("Mínimo 8 caracteres, mayúsculas, minúsculas y números", "enfermeria"); ?>" autocomplete="off"<?php echo (isset($registerpass) ? ' value="'.$registerpass.'"' : ''); ?><?php echo (isset($registerpass) ? ' value="'.$registerpass.'"' : ''); ?> required /></p>

        <?php /* <p><label for="name_register"><?php _e("Nombre", "enfermeria"); ?></label>
        <input class="form-control" id="name_register" type="text" name="firstname" autocomplete="given-name" placeholder="<?php _e("Nombre", "enfermeria"); ?>"/></p>
        <p><label for="lastname_register"><?php _e("Apellidos", "enfermeria"); ?></label>
        <input class="form-control" id="lastname_register" type="text" name="lastname" autocomplete="family-name" placeholder="<?php _e("Apellidos", "enfermeria"); ?>"/></p>
        <p><label for="email_register"><?php _e("Email", "enfermeria"); ?></label>
        <input class="form-control" id="email_register" type="email" name="email" placeholder="<?php _e("nombre@euskadi.eus", "enfermeria"); ?>" autocomplete="off" /></p>
        <p><label for="password_register"><?php _e("Contraseña", "enfermeria"); ?></label>
        <input class="form-control" id="password_register" type="password" name="password" placeholder="<?php _e("Mínimo 8 caracteres, mayúsculas, minúsculas y números", "enfermeria"); ?>" autocomplete="off"<?php echo (isset($registerpass) ? ' value="'.$registerpass.'"' : ''); ?> /></p> */ ?>

         <input class="btn btn-primary" type="submit" value="<?php _e("Registro", "enfermeria"); ?>" />
    </form>
</div>