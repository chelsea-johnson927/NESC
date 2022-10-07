<?php  

get_header();  

echo '<div class="container-fluid"> 
		<div class="row"> 
			<div class="col-sm-12 main-content">';  

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		//
		the_content();// Post Content here
		//
	} // end while
} // end if

echo '</div> 
      </div> 
	  </div> 
	  </main>'; 

get_footer(); 
?> 

