<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NESCTheme
 */

?>

     </main>
	<footer id="colophon" class="site-footer">  
		<div class="container"> 
			<div class="row"> 
				<div class="col-sm-12 footer-content">
					<div class="site-info">   
					<?php dynamic_sidebar( 'sidebar-1' ); ?>


					</div>
				</div> 
            </div>

				<div class="row"> 
				<div class="col-sm-12" style="text-align:center;">
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'nesctheme' ), 'nesctheme', 'synthcube' );
				?>
				</div></div> 
</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
