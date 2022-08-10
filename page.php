<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NESCTheme
 */

get_header();
?>

<div class="container-fluid"> 
    <div class="row"> 
		<div class="col-sm-12"> 
			<div class="single-page-content">

		<?php
		
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();  
				the_content(); 
				//
				// Post Content here
				//
			} // end while
		} // end if

		?> 
	</div>
	</div> 
	</div> 
	</div>
	</main><!-- #main -->

<?php

get_footer();
