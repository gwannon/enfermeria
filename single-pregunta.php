<?php get_header(); ?>
<div class="col">
    <?php if(is_user_logged_in()) { ?>
        <?php $user = wp_get_current_user();
        if (!in_array( 'subscriber', (array) $user->roles ) ) { ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
                <?php $adjunto = get_field('adjunto', $post->ID);
                if($adjunto != '') { ?>
                    <a class="btn btn-primary" target="_blank" href="<?php echo $adjunto; ?>"><?php _e("Ver adjunto", "enfermeras"); ?></a>
                <?php } ?>
                <?php 
                    $respuesta = get_field('respuesta', $post->ID);
                    if($respuesta != '') { ?>
                    <hr>
                    <h2><?php _e("Respuesta", "enfermeria"); ?></h2>
                    <div class="p-3 mb-3 border">
                        <?php echo $respuesta; ?>
                    </div>
                    
                <?php } else { ?>
                    <div class="alert alert-primary" role="alert"><?php _e("Esta pregunta todavía no ha sido contestada.", "enfermeria"); ?></div>
                <?php } ?>
            <?php endwhile; ?>
        <?php } else { ?>
            <div class="alert alert-primary" role="alert"><?php _e("Su perfíl todavía no esta aprobado por los administradores.", "enfermeria"); ?></div>
        <?php } ?>
    <?php } else { ?>
        <?php include_once(__DIR__."/templates/loginregistro.php"); ?>
    <?php } ?>
</div>
<?php get_footer();