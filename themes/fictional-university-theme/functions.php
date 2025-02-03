<?php
require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/search-route.php');



function university_custom_rest() {
    register_rest_field('post', 'authorName', array(
        'get_callback' => function() {return get_the_author();}
    ));
    register_rest_field('note', 'userNoteCount', array(
        'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note');}
    ));
    register_rest_field('note', 'userNoteLimit', array(
        'get_callback' => function() {return 10 ;}
    ));

}
add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args = NULL){

    if (!isset($args['title']) OR $args['title'] == "") {
        $args['title'] = get_the_title();
    }

    if ( !isset($args['subtitle']) OR $args['subtitle'] == "") {
            $args['subtitle'] = get_field('page_banner_subtitle');
    } elseif (isset($args['subtitle']) AND !$args['subtitle'] == "") {
        $args['subtitle'] = $args['subtitle'];
    }
     
    
    if ( !isset($args['photo']) OR $args['photo'] == ""){
        if ( get_field('page_banner_background_image') ) {
           $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } elseif(isset($args['photo']) AND !$args['photo'] == ""){
            $args['photo'] == $args['photo'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
?>
<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php 
     echo $args['photo'];
      ?>"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
        <p><?php
            echo $args['subtitle']
       ?> </p>
         
        </div>
      </div>
</div>

    <?php
}
?>
 <?php
function university_files() {
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    //  wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js', js dependencies?, version, page_bottom? );
    wp_enqueue_style( 'custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome-4', get_theme_file_uri('../../../wp-includes/font-awesome-4.7.0/css/font-awesome.min.css'));
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
    
    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}

add_action('wp_enqueue_scripts','university_files');

// Register Your Dynamic Menus here

function university_features() {
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('FooterMenuLocationA', 'Footer A');
    // register_nav_menu('FooterMenuLocationB', 'Footer B');
    add_theme_support('menu');
    add_theme_support('post-thumbnails'); //  featured images for blog posts
    add_theme_support('title-tag');
    add_image_size( 'professorLandscape', 400, 260, true );
    add_image_size( 'professorPortrait', 480, 650, true );
    add_image_size( 'pageBanner', 1500, 350, true );

};

add_action('after_setup_theme', 'university_features'); // calls university_actions during WP after_setup_theme hook (lifecycle hook)

function university_adjust_queries($query) {
    if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('posts_per_page','-1');
        $query->set( 'orderby','title');
        $query->set( 'order','ASC');
        }

    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('posts_per_page','2');
        $query->set(  'key','event_date');
        $query->set(  'meta_key','event_date');
        $query->set( 'orderby','meta_value_num');
        $query->set( 'order','ASC');
        $query->set( 'meta_query', array(
            array(
              'key' => 'event-date-selector',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
            )
            ));/**/
        }
}
add_action('pre_get_posts','university_adjust_queries');

function universityMapKey($api) {
    $api['key'] = 'AIzaSyDU1kHrjt44uW8FZxxY-Ry3mCPq1799Gfk';
    return $api;
}
add_filter('acf/fields/google_map/api','universityMapKey');




// Redirect subscriber accounts out of admin and onto Home page

add_action('admin_init','redirectSubsToFrontend');

function redirectSubsToFrontend() {
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('wp_loaded','noSubsAdminBar');
function noSubsAdminBar() {
    $ourCurrentUser = wp_get_current_user();
    if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

// Customize login screen
add_filter('login_headerurl', 'ourLoginHeaderUrl');

function ourLoginHeaderUrl() {
    esc_url(site_url('/'));
};

add_filter('login_headertitle', 'ourLoginHeaderTitle');

function ourLoginHeaderTitle() {
    return get_bloginfo('name');
};

add_action('login_enqueue_scripts','ourLoginCSS');

function ourLoginCSS() {
    wp_enqueue_style('font-awesome-4', get_theme_file_uri('../../../wp-includes/font-awesome-4.7.0/css/font-awesome.min.css'));
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

// Use Filter to Force notes posts to be private
add_filter('wp_insert_post_data','makeNotePrivate', 10, 2 );
// Explain above parameters 10,2:
// 2: accepts 2 params                        
// 10: is priority of the callback - if ordering filters use lower number for sooner (10), higher number for later (99)

function makeNotePrivate($data, $postarr) { //2 params
    if ($data['post_type'] == 'note') {
        // Per User Post  limit
        if(count_user_posts(get_current_user_id(), 'note') > 8 AND !$postarr['ID']) {
            die("You have reached your note limit.");
        }
        // Make sure no html tags are added
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }
    if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash' ) {
        $data['post_status'] = 'private';
    }
    return $data;
}



?>