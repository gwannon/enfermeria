<?php get_header(); ?>
<?php if(is_user_logged_in()) { ?>
    <?php $user = wp_get_current_user();
        if (!in_array( 'subscriber', (array) $user->roles ) ) { ?>
            <?php if(isset($_GET['action']) && $_GET['action'] == 'create') { ?>
                <h2><?php _e("Hacer pregunta", "enfermeria"); ?></h2>
                <?php include_once(__DIR__."/templates/hacerpregunta.php"); ?>
            <?php } else { ?>
                <h2><?php _e("Preguntas", "enfermeria"); ?></h2>
                <?php include_once(__DIR__."/templates/preguntas.php"); ?>
            <?php } ?>
    <?php } else { ?>
        <div class="alert alert-primary" role="alert"><?php _e("Su perfíl todavía no esta aprobado por los administradores.", "enfermeria"); ?></div>
    <?php } ?>
<?php } else { ?>
    <?php include_once(__DIR__."/templates/loginregistro.php"); ?>
<?php } ?>
<?php get_footer();