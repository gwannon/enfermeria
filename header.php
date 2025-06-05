<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php wp_title(); ?></title>
	<link href="/favicon.ico" rel="shortcut icon"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<section class="container">
    <div class="row">
		<div class="col">
        	<h1><a href="<?php echo get_home_url(); ?>"><?php _e("Consultas enfermeria", "enfermeria"); ?></a></h1>
		</div>
		<?php if(is_user_logged_in()) { ?>
			<div class="col text-end">
				<?php $user = wp_get_current_user();
    				if (in_array('approved-subscriber', (array) $user->roles ) ) { ?>
						<a class="btn btn-success" href="<?php echo get_home_url(); ?>?action=create"><?php _e("Hacer pregunta", "enfermeria"); ?></a>
					<?php } ?>
				<a class="btn btn-primary" href="<?php echo wp_logout_url("/?logout=ok"); ?>"><?php _e("Salir", "enfermeria"); ?></a>
			</div>
		<?php } ?>
    </div>
	<div class="row">