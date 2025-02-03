<?php
get_header() ?>
  
    <?php
    
    //    some variabes
    $theParent = wp_get_post_parent_id(get_the_ID());
    $parentLink = get_permalink($theParent);

    pageBanner(); 

        while(have_posts()) {
            the_post(); ?>
          
           <div class="container container--narrow page-section">
            
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a href="<?php echo get_post_type_archive_link('program') ?>" class="metabox__blog-home-link"><i class="fa fa-home"></i>
                All Programs</a> <span class="metabox__main"><?php the_title() ?></span></p>
            </div>

            <div class="generic-content">
                <!-- <?php the_content() ?> -->
                <?php the_field('programs_main_content_editor') ;?>
            </div>

        <?php $relatedProfessors =   new WP_Query(array(
              'post_type' => 'professor',
              'posts_per_page' => -1,
              'orderby' => 'title',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                    'key' => 'related_programs', // arr(12,23,34)
                    'compare' => 'LIKE',
                    'value' => '"'.get_the_id().'"'
                  ),
              )
         ));
       
         if ( $relatedProfessors->have_posts()) {
            echo '<hr class="section-break"/>';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>'; // concat plural or singular version
            echo '<ul class="link-list min-list">';
            echo '<ul class="professor-cards">';

            while ($relatedProfessors->have_posts()) {
                $relatedProfessors->the_post(); ?>
           
                <li class="professor-card__list-item">
                    <a class="professor-card"  href="<?php the_permalink() ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>" alt="" />
                        <span class="professor-card__name">
                            <?php the_title() ?>
                        </span>
                    </a>
                </li>
     
            <?php   }
             echo '</ul>';
            ?>
         
         
    <?php    }?>
           <!-- **************** -->

            <?php
           wp_reset_query();
           wp_reset_postdata(); // Restore original post data

            $today = date('Ymd');
            $relatedEvents =   new WP_Query(array(
              'post_type' => 'event',
              'posts_per_page' => 3,
              'meta_key' => 'event-date-selector',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                  'key' => 'event-date-selector',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                ),
                array(
                    'key' => 'related_programs', // arr(12,23,34)
                    'compare' => 'LIKE',
                    'value' => '"'.get_the_id().'"'
                  ),
              )
         ));
       
         if ( $relatedEvents->have_posts()) {
            echo '<hr class="section-break"/>';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>'; // concat plural or singular version
            echo '<ul class="link-list min-list">';
        
       
            while ($relatedEvents->have_posts()) {
                $relatedEvents->the_post();
                  get_template_part('template-parts/content-event');
              }
            ?>
         
           </div> 
    <?php    }
         }
    ?>
    <?php
get_footer() ?>