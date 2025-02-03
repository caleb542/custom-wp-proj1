<!DOCTYPE html>
<html <?php language_attributes(); ?>
<head>
    <meta charset="<?php bloginfo('charset')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  <style>
    /* fix the image in log out button */
    .site-header__avatar {
      float:left;
      position:relative;
      margin-right:10px;
    }
    .btn--with--photo {
      padding:0 10px 0 0;
    }
    .btn__text{
      position:relative;
      margin: 0 auto;
      height:30px;
      line-height:30px;
    }
  </style>
  </head>
<body <?php body_class(); ?> >

<header class="site-header">
      <div class="container">
        <h1 class="school-logo-text float-left">
          <a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a>
        </h1>
        
        <a href="<?php echo esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>

        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">
          <!-- replace the menu below with dynamic menus
           by commenting out the menu below and register menus in 
           functions.php.  Then add the Dynamic reference in header and footer php files as below

            <?php

              global $wp;
              $current_url = home_url( add_query_arg( array(), $wp->request ) );

                wp_nav_menu(array(
                'theme_location' => 'headerMenuLocation' 
                ))
                ?>
            -->
            <ul>
              <li
              <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 1392) echo 'class="current-menu-item"' ?>>
                <a href="<?php echo site_url('/about-us')?>">About Us</a></li>
                <li <?php 
              if ( get_post_type() == 'program'  OR (is_page('programs')) OR str_contains($current_url, '/programs')) echo 'class="current-menu-item"'; ?>>
                <a href="<?php echo get_post_type_archive_link('program') ?>">Programs</a></li>
              <li <?php 
              if ( get_post_type() == 'event' OR is_page('past-events') OR (is_page('event')) OR str_contains($current_url, '/events')) echo 'class="current-menu-item"'; ?>>
                <a href="<?php echo get_post_type_archive_link('event') ?>">Events</a></li>
                <li <?php 
              if ( get_post_type() == 'campus' OR is_page('campuses') OR (is_page('campus')) OR str_contains($current_url, '/campus')) echo 'class="current-menu-item"'; ?>>
                <a href="<?php echo get_post_type_archive_link('campus') ?>">Campuses</a></li>
              <li
              <li
              <?php if ( get_post_type() == 'post') echo 'class="current-menu-item"' ?>>
              <a href="<?php echo site_url('/blog')?>">Blog</a></li>
            </ul>
          </nav>
          <div class="site-header__util">
            <?php if (is_user_logged_in()) { ?>
              <a href="<?php echo site_url('/my-notes'); ?>" class="btn btn--small btn--orange float-left push-right">My Notes</a>
              <a href="<?php echo wp_logout_url(); ?>"  class="btn btn--small btn--dark-orange float-left btn--with--photo">
                <span class='site-header__avatar'>
                  <?php echo get_avatar(get_current_user_id(), 60); ?>
                </span>
                <span class="btn__text">Log Out</span> </a>
            <?php } else { ?> 
            <a href="<?php echo wp_login_url(); ?>" class="btn btn--small btn--orange float-left push-right">Log In</a>
            
            <a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
            <?php } ?>
            <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </header>
