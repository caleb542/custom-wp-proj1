


<?php
get_header() ?>
  
    <?php
    
    //    some variabes
    $theParent = wp_get_post_parent_id(get_the_ID());
    $parentLink = get_permalink($theParent);

        while(have_posts()) {
            the_post(); 
            pageBanner() ?>
          
           <div class="container container--narrow page-section">
            
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a href="<?php echo get_post_type_archive_link('event') ?>" class="metabox__blog-home-link"><i class="fa fa-home"></i>
                Events Home</a> <span class="metabox__main"><?php the_title() ?></span></p>
            </div>

            <div class="generic-content"><?php the_content() ?></div>
          
            <?php  $relatedPrograms = get_field('related_programs');
          
            if ($relatedPrograms) { // check to see if there are any related programs associated with this event
                
                $sizeOfPrograms = sizeof($relatedPrograms); // check the array size for heading grammar
                                                            // (I don't like this static treatment: Related program(s) )
                if($sizeOfPrograms > 1 ) {
                  $relatedProgramsHeading = 'Related Programs'; // Plural title - or
                } else {  
                  $relatedProgramsHeading = 'Related Program'; // singlular title exp 
                }
                echo '<hr class="section-break"/>';
                echo '<h2 class="headline headline--medium">'.$relatedProgramsHeading.'</h2>'; // concat plural or singular version
                echo '<ul class="link-list min-list">';
            
              foreach($relatedPrograms as $program) { ?>
                <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program) ?></a></li>
            <?php
               
               } 
               echo '</ul>'; }  ?>
        
              </div> 
           
    <?php    }
    ?>
    <?php
get_footer() ?>