<?php  get_header(); ?>

<div class="container page">  
    <div class="row"> 
        <div class="col-sm-12">  
             

            <?php   

                    
                    
                
                $query = new WP_Query( array('post_type' =>  'events' ));
           
 
                // The Loop
                if ( $query->have_posts() ) {
                
                   

                while ( $query->have_posts() ) {
                        $query->the_post();
               
                        $featured_img_url = get_the_post_thumbnail_url();   
                        $permalink = get_permalink();
                        $title = get_the_title();
                        $excerpt = get_the_excerpt();  
                        $categories = get_the_category(); 


                        echo '<div class="row post-row"> 
                                <div class="col-sm-6"> 
                                <div class="post-thumbnail" style="background-image:url('.$featured_img_url.');"></div> 
                                </div>'; 

                        echo '<div class="col-sm-6 post-content-wrap"> 
                                <div class="post-content"> 
                                 <h4 class="post-title">'. $title . '</h4> 
                                 <p class="post-excerpt">'. $excerpt . '</p>  
                                 <button class="post-bttn"><a href="'.$permalink .'"> Register For This  ' . esc_html( $categories[0]->name ) .' here</a></button>
                                
                               </div> 
                               </div> 
                               </div>';  
            } 

            
               
            } else {
         echo 'no posts found';
            } 
/* Restore original Post Data */
wp_reset_postdata();

            ?>



</div>

    </div>
</div>

<?php get_footer(); ?>