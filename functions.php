<?php

define ("MAIN_PAGE_ID", 2);
define ("EMAILS_AVISO", get_option("_enfermeria_email"));

/* ----------- Multi-idioma ------------------ */
function enfermeria_plugins_loaded() {
	load_plugin_textdomain('enfermeria', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
}
add_action('plugins_loaded', 'enfermeria_plugins_loaded', 0 );

/* ---------------- Boostrap ------------------------ */ 
function enfermeria_bootstrap_enqueue_styles() {
    wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'style-css', get_template_directory_uri().'/style.css' );
    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array(), '1.0.0', true ); // Used for loading scripts
    wp_enqueue_style( 'google-font', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap' );

}
add_action('wp_enqueue_scripts', 'enfermeria_bootstrap_enqueue_styles');

/* -------------------- Adminbar ----------------------------- */
function enfermeria_admin_bar(){
  if(is_user_logged_in()){
    $user = wp_get_current_user();
    if (in_array('subscriber', (array) $user->roles ) || in_array('approved-subscriber', (array) $user->roles ) ) {
      add_filter( 'show_admin_bar', '__return_false' , 1000 );
    }
  }
}
add_action('init', 'enfermeria_admin_bar' );


//No dejamos entrar a los suscriptores a WP-ADMIN
if ( is_user_logged_in() && is_admin() ) {
    global $current_user;
    get_currentuserinfo();
    $user_info = get_userdata($current_user->ID);
    if ( $user_info->wp_user_level == 0 )  {
        header( 'Location: '.get_bloginfo('home').'/' );
    }
}

//metemos la respuesta en la búsqueda
function searchfilter($query) {
  if ($query->is_search && !is_admin() ) {
      if(isset($_GET['post_type'])) {
          $type = $_GET['post_type'];
              if($type == 'pregunta') {
                  $query->set('post_type',array('pregunta'));
              }
      }       
  }
  return $query;
}

//Preparar logeo

function enfermeria_wp_login_form() {
  $args = ['label_username' => __('Email', "enfermeria"), 'echo' => false];
  $login = wp_login_form($args);
  $login = str_replace( 'class="button button-primary"', 'class="btn btn-primary"', $login );
  $login = str_replace( 'class="input"', 'class="form-control"', $login );
  return $login;
}

function enfermeria_custom_login_logo() {
    echo '<style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(' . get_stylesheet_directory_uri() . '/images/webosk00-logo-osakidetza.png);
            height: 100px; /* Change the height as needed */
            width: 100%; /* Use 100% width for responsiveness */
            background-size: contain; /* Adjust this property as needed */
        }
    </style>';
}

add_action('login_enqueue_scripts', 'enfermeria_custom_login_logo');

//Administrador 
add_action( 'admin_menu', 'enfermeria_plugin_menu' );

function enfermeria_plugin_menu() {
	add_options_page( __('Enfermería', "enfermeria"), __('Enfermería', "enfermeria"), 'manage_options', "enfermeria", 'enfermeria_page_settings');
}

function enfermeria_page_settings() { 
	?><h1><?php _e("Administrar sistema de preguntas", "enfermeria"); ?></h1>
	<?php if(isset($_REQUEST['sendadmin']) && $_REQUEST['sendadmin'] != '') { 
		?><p style="border: 1px solid green; color: green; text-align: center;"><?php _e("Datos guardados correctamente.", 'wp-a-tu-gusto'); ?></p><?php
		update_option('_enfermeria_email', $_POST['_enfermeria_email']);
	} ?>
	<form method="post">
		<b><?php _e("Emails de aviso", "enfermeria"); ?>:</b><br/>
		<input type="text" name="_enfermeria_email" value="<?php echo get_option("_enfermeria_email"); ?>" style="width: calc(100% - 20px);" placeholder="<?php _e("separados por comas", "enfermeria"); ?>" /><br/><br/>
		<input type="submit" name="sendadmin" class="button button-primary" value="<?php _e("Guardar", "enfermeria"); ?>" />
	</form>
	<?php
}

//FOoter

function enfermeria_register_widget_areas() {
  register_sidebar( array(
    'name'          => 'Footer 1',
    'id'            => 'footer_1',
    'description'   => __('Footer col 1', "enfermeria"),
    'before_widget' => '<div class="col-4">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));

    register_sidebar( array(
    'name'          => 'Footer 2',
    'id'            => 'footer_2',
    'description'   => __('Footer col 2', "enfermeria"),
    'before_widget' => '<div class="col-4">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));

    register_sidebar( array(
    'name'          => 'Footer 3',
    'id'            => 'footer_3',
    'description'   => __('Footer col 3', "enfermeria"),
    'before_widget' => '<div class="col-4">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));
 
}

add_action( 'widgets_init', 'enfermeria_register_widget_areas' );