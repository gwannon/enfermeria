<div class="col-12">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link<?php echo (!isset($_GET['cat']) ? " active" : ""); ?>" href="<?php the_permalink(MAIN_PAGE_ID);?>"><?php _e("Todas", "enfermeria"); ?></a>
        </li>
        <?php
        $terms = get_terms( array(
            'taxonomy' => 'categoria-pregunta',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC'
        ) );
        foreach($terms as $term) { ?>
            <li class="nav-item">
                <a class="nav-link<?php echo (isset($_GET['cat']) && $_GET['cat'] == $term->slug ? " active" : ""); ?>" href="<?php the_permalink(MAIN_PAGE_ID);?>?cat=<?php echo $term->slug; ?>"><?php echo $term->name; ?> (<?php echo $term->count; ?>)</a>
            </li>
        <?php } ?>
    </ul>
</div>
<div class="col-12 p-3">
    <div class="accordion" id="preguntas">
    <?php

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'post_type' => 'pregunta',
            'paged' => $paged,
            'posts_per_page' => 10,
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'post_date'
        );

        if(isset($_GET['cat']) && $_GET['cat'] != '') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'categoria-pregunta',
                    'terms' => $_GET['cat'],
                    'field' => 'slug',
                    'include_children' => true,
                    'operator' => 'IN'
                )
            );
        }

        $the_query = new WP_Query( $args);
        while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo $post->ID; ?>">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $post->ID; ?>" ria-expanded="true" aria-controls="collapse<?php echo $post->ID; ?>">
                        <?php the_title(); ?>
                    </button>
                </h2>
                <div id="collapse<?php echo $post->ID; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $post->ID; ?>" data-bs-parent="#preguntas">
                    <div class="accordion-body">
                        <?php the_excerpt(); ?>
                        <p><em><?php printf(__("Por %s %s", "enfermeria"), get_the_author_meta('first_name', $post->post_author), get_the_author_meta('last_name', $post->post_author)); ?></em></p>
                        <a class="btn btn-primary" href="<?php the_permalink(); ?>"><?php _e("Ver pregunta completa", "enfermeras"); ?></a>
                    </div>
                </div>
            </div>
        <?php } // end of the loop. ?>
    </div>
</div>
<div class="col">
    <?php echo wp_pagenavi( array( 'query' => $the_query)); ?>
</div>