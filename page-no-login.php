<?php 

/* Template Name: Zona sin login */

get_header(); ?>
<!-- Zona sin login -->
<?php if (have_posts()) : while (have_posts()) : the_post();?>
    <div class="post">
        <h1><?php the_title();?></h1>
        <?php the_content(); ?>
    </div>
<?php endwhile; endif; ?>
<?php get_footer();
