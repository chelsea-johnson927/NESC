<?php  

get_header();  

echo '<main id="page-content">';  

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		//
		the_content();// Post Content here
		//
	} // end while
} // end if

echo '</main>'; 

get_footer(); 
?> 

