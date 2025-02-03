<?php 
get_header()
?>

<?php
pageBanner( array(
              'title'=> 'All Events',
              'subtitle'=> "See what's going on in our World!",
              'photo' => get_theme_file_uri('/images/apples.jpg'),
              'photo' => ''

            )); ?>

<div class="container container--narrow page-section">

    <?php
     $today = date('Ymd');
    //  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
     $myEvents =  new WP_Query(array(
          'post_type' => 'event',
          'posts_per_page' => -1,
          'paged' => $paged,
          'meta_key' => 'event-date-selector',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query' => array(
            array(
              'key' => 'event-date-selector',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
            )
          )
     ));


    while($myEvents->have_posts()) {
      $myEvents->the_post();
      get_template_part('template-parts/content-event');
      };
        echo paginate_links();


   
    ?>
    <hr class="section-break">
    <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events')?>">Check out our Past Events archive</a>.</p>
    </div>

<?php
get_footer() 
?>