<?php

if(isset($_POST['submit'])){
    $user = wp_get_current_user();

    //Creamos la pregunta
    $post_id = wp_insert_post( array(
        'post_status' => 'draft',
        'post_type' => 'pregunta',
        //'post_title' => $_REQUEST['title'],
        'post_title' => substr($_REQUEST['content'], 0, 150)." ...",
        'post_content' => $_REQUEST['content'],
        'post_author' => $user->ID
    ) );

    //Asignamos categoría
    $term = get_term_by( 'id', $_REQUEST['category'], 'categoria-pregunta');
    wp_set_object_terms($post_id, $term->term_id, 'categoria-pregunta');
    
    //Subimos ficheros
    if(!empty($_FILES['file']['name']) && $_FILES['file']['error'] == 0) {
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        $attachment = media_handle_upload('file', $user->ID);
        update_field('adjunto', $attachment, $post_id);
    } ?>
        <div class="alert alert-success" role="alert"><?php _e("Pregunta creada correctamente. Recibiras un mensaje cuando se elabore la respuesta.", "enfermeria"); ?></div>
    <?php 
}

?>
<form method="post" enctype="multipart/form-data">
    <?php /* <label for="inputTitle" class="form-label"><b><?php _e("Pregunta", "enfermería"); ?></b></label>
    <input class="form-control" id="inputTitle" type="text" name="title" placeholder="<?php _e("Pregunta", "enfermería"); ?>" style="width: 100%;" required /><br/> */ ?>
    <label for="inputContent" class="form-label"><b><?php _e("Pregunta", "enfermería"); ?></b></label>
    <textarea class="form-control" id="inputContent" name="content" placeholder="<?php _e("Danos los más datos posibles.", "enfermería"); ?>" style="width: 100%; min-height: 200px;" required></textarea><br/>
    <p><b><?php _e("Categoría", "enfermería"); ?></b></p>
    <div class="form-check">
        <?php
            $terms = get_terms( array(
                'taxonomy' => 'categoria-pregunta',
                'hide_empty' => false,
                'orderby' => 'name',
                'order' => 'ASC'
            ) );
            foreach($terms as $term) { ?>
                <label><input class="form-check-input" type="radio" name="category" value="<?php echo $term->term_id; ?>" required /> <?php echo $term->name; ?></label>
        <?php } ?>
    </div><br/>
    <label for="formFile" class="form-label"><b><?php _e("¿Quieres añadir algún documento?", "enfermería"); ?></b></label>
    <input class="form-control" type="file" name="file" id="formFile"><br/>
    <input type="submit" class="btn btn-primary" value="<?php _e("Enviar", "enfermería"); ?>" name="submit">
</form>