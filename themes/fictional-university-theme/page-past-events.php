<?php 
get_header()
?>

<?php
pageBanner( array(
              'title'=> '',
              'subtitle'=> '',
              'photo' => 'https://fastly.picsum.photos/id/77/450/300.jpg?hmac=V_LawevwSaVitpQs2t7AnuBi84UPSNl1Qp3PmKkmaXc',
            )); ?>

<div class="container container--narrow page-section">

    <?php
     $today = date('Ymd');
    //  $paged = ( get_query_var( 'paged',1) );
     $pastEvents =  new WP_Query(array(
          'post_type' => 'event',
          // 'posts_per_page' => 1,
          'paged' => get_query_var( 'paged', 1 ),
          'meta_key' => 'event-date-selector',
          'orderby' => 'meta_value_num',
          'order' => 'DESC',
          'meta_query' => array(
            array(
              'key' => 'event-date-selector',
              'compare' => '<',
              'value' => $today,
              'type' => 'numeric'
            )
          )
     ));


    while($pastEvents->have_posts()) {
      $pastEvents->the_post();
      get_template_part('template-parts/content-event');
    };
          echo paginate_links(array(
            'total' => $pastEvents->max_num_pages
          ));
       
       // wp_reset_postdata();

   
    ?>
    </div>

<?php
get_footer() 
?>