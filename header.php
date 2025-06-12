<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo get_bloginfo('name'); ?></title>
	<link href="/favicon.ico" rel="shortcut icon"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<section class="container">
    <div class="row mt-3">
		<div class="col">
        	<h1><a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/webosk00-logo-osakidetza.png" alt="<?php _e("Consultas enfermeria", "enfermeria"); ?>" /></a></h1>
		</div>
		<?php if(is_user_logged_in()) { ?>
			<div class="col d-flex flex-row align-items-center justify-content-end">
				<form method="get" action="<?php echo get_home_url(); ?>" class="d-flex me-2">
					<input class="form-control me-2" type="text" name="buscar" value="<?php echo strip_tags($_GET['buscar']); ?>" placeholder="<?php _e("Buscar", "enfermeria"); ?>" />
					 <button type="submit" class="btn btn-primary" title="<?php _e("Buscar", "enfermería"); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
</svg></button>
				</form>
				<?php $user = wp_get_current_user();
    				if (in_array('approved-subscriber', (array) $user->roles ) ) { ?>
						<a class="btn btn-success me-2" href="<?php echo get_home_url(); ?>?action=create"><?php _e("Hacer pregunta", "enfermeria"); ?></a>
					<?php } ?>
				<a class="btn btn-primary" href="<?php echo wp_logout_url("/?logout=ok"); ?>"><?php _e("Salir", "enfermeria"); ?></a>
			</div>
		<?php } ?>
    </div>
	<div class="row">