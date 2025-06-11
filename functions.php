<?php

define ("MAIN_PAGE_ID", 2);

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

/* Registrar usuario */
add_action( 'admin_post_nopriv_custom_registration', 'enfermeria_custom_make_new_user' ); // the format here is "admin_post_nopriv_" + [the hidden action you put in the html form]


function enfermeria_custom_make_new_user(){

  // TODO: validate the nonce before continuing

  // TODO: validate that all incoming POST data is OK

  $user = sanitize_title($_POST['email']); // potentially sanitize these
  $pass = $_POST['password']; // potentially sanitize these
  $email = $_POST['email']; // potentially sanitize these
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  
  $user_id = wp_create_user( $user, $pass, $email ); // this creates the new user and returns the ID

  if($user_id){ // if the user exists/if creating was successful.
    $user = new WP_User( $user_id ); // load the new user

    $userdata = array(
        'ID' => $user_id,
        'first_name' => $firstname,
        'last_name' => $lastname,
    );
    wp_update_user( $userdata );

    $user->set_role('subscriber'); // give the new user a role, in this case a subscriber

    $display_name = get_the_author_meta('first_name', $user_id)." ".get_the_author_meta('last_name', $user_id);

    wp_update_user( array ('ID' => $user_id, 'display_name' => $display_name));

    // now add your custom user meta for each data point
    //update_user_meta($user_id, 'institute', $institute);

    wp_redirect('/?register=ok'); // redirect to some sort of thank you page perhaps.
  }else{
    // user wasn't made
  }
}

function enfermeria_wp_login_form() {
  $args = ['label_username' => 'Email', 'echo' => false];
  $login = wp_login_form($args);
  $login = str_replace( 'class="button button-primary"', 'class="btn btn-primary"', $login );
  $login = str_replace( 'class="input"', 'class="form-control"', $login );
  return $login;
}

