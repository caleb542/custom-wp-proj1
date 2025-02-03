<?php 
get_header()
?>

<?php
pageBanner( array(
    'title'=> 'All Campuses',
    'subtitle'=> 'We have several conveniently located campuses',
));
?>
<div class="container container--narrow page-section">

    <?php
     $today = date('Ymd');
    //  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
     $campuses =  new WP_Query(array(
          'post_type' => 'campus',
          'posts_per_page' => -1,
          'paged' => get_query_var( 'paged', 1 ),
          //'meta_key' => 'event-date-selector',
          'orderby' => 'title',
          'order' => 'ASC',
          
     ));
     ?>
<ul class="link-list min-list"> 
<?php
    while($campuses->have_posts()) {
      $campuses->the_post();
    //   $map_location = get_field('google_maps_url');
    ?>
        <li><a href="<?php the_permalink()?>"><?php the_title()?></a></li>
        <!-- <li><a href="<?php echo $map_location ?>">See the location in google maps</a></li> -->
        <?php  
      
        };
        echo paginate_links(array(
            'total' => $campuses->max_num_pages
          ));
        wp_reset_postdata();

   
    ?>
    <!-- <hr class="section-break">
    <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events')?>">Check out our Past Events archive</a>.</p> -->
    </div>

<?php
get_footer() 
?>