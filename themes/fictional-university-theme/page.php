
<?php
    get_header();
    
    while(have_posts()) {
            the_post(); 
            pageBanner( array(
              'title'=> '',
              'subtitle'=> '',
              'photo' => '',
            )); 
            ?>
    
   

    <div class="container container--narrow page-section">
    
      <?php
       // some variables for parent page and its permalink 
       $theParent = wp_get_post_parent_id(get_the_ID());
       $parentLink = get_permalink($theParent);
      
      ?>
<?php 
    $testArray = get_pages(array(
        'child_of' => get_the_ID() // if the current page has children this will return a collection
    ));

if($theParent or $testArray ) { ?> <!-- if the page has a paren OR if it IS a parent show breadcrumb links -->

      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent)?>"><?php echo get_the_title($theParent) ?></a></h2>
        
      
        <ul class="min-list">
          <?php  
            if ($theParent) {
            $findChildrenOf = $theParent;
            } else {
                $findChildrenOf = get_the_ID();
            }
            wp_list_pages( array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order'
            ));
            ?>

         
        </ul>
      </div> 

<?php } ?>

      <div class="generic-content">
      <?php the_content(); ?>
      </div>
    </div>

    <?php    }
    get_footer();
?>
</body>
</html>

<!--
<?php 
$theParent = wp_get_post_parent_id( get_the_ID() );
if ($theParent) { ?>
<div class="metabox metabox--position-up metabox--with-home-link">
    <p><a href="<?php echo get_permalink($theParent) ?>" class="metabox__blog-home-link"><i class="fa fa-home"></i>
     Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title() ?></span></p>
</div> 
<?php }
?>
-->