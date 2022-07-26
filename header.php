<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NESCTheme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'nesctheme' ); ?></a>

			<?php if ( is_front_page() && is_home() ){ 

				echo '<header class="light-theme">'; 

			}else{ 

				echo '<header class="dark-theme">'; 

			} 

			?> 

			<div class="container"> 
				<div class="row"> 
					<div class="col-sm-12"> 
						<nav id="navBar" class=""> 
							   

							<button id="navBttn" class="bttn"  type="button">  
								<span class="lines"></span>   

						<?php esc_html_e( ' Menu', 'newenglandsynthesizertheme' ); ?> 
							</button>

						<?php 
						wp_nav_menu(
							array( 
						'menu' => 'primary',	
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						)
						);
							
							 ?> 
					
					</nav> 
					</div>   
				<div class="row">
				  <div class="col-sm-12">  

						<h1 class="site-header"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?> </a></h1> 
						<h2 class="site-tagline"><?php bloginfo( 'description' ); ?></h2> 

					</div> 
				</div>
				</div> 
					</header>
				
		
		
		











		
				


						

		
	</header><!-- #masthead -->
