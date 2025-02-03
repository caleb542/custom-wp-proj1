

<?php
get_header() ?>
  
    <?php
    
    //    some variabes
    $theParent = wp_get_post_parent_id(get_the_ID());
    $parentLink = get_permalink($theParent);

        while(have_posts()) {
            the_post(); 
            pageBanner( array(
              'title'=> '',
              'subtitle'=> '',
              'photo' => '',
            )); ?>
          
           <div class="container container--narrow page-section">
            
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a href="<?php echo site_url('/blog') ?>" class="metabox__blog-home-link"><i class="fa fa-home"></i>
                Blog Home</a> <span class="metabox__main"><?php the_title() ?> Posted by <?php the_author_posts_link() ?> on <?php the_time('n.j.Y') ?> in <?php echo get_the_category_list(', ')?></span></p>
            </div>

            <div class="generic-content">
                <?php the_content() ?>
            </div>
           </div> 
    <?php    }
    ?>
    <?php
get_footer() ?>
