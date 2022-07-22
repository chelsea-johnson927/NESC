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
				
				$textColor = '#000'; 
				$backgroundColor = '#fff';
				
				}else{  

					$textColor = '#fff'; 
					$backgroundColor = '#000';

			 		} ?>
				
			<header id="masthead" class="site-header" style="background-color:<?php echo $backgroundColor ?>">
				<div class="container site-header-wrapper"> 
					<div class="row">  
						<div class="col-sm-12"> 
						<nav id="site-navigation" class="main-navigation">
							<button class="bttn" aria-controls="primary-menu" aria-expanded="false"><span class="lines" style="background:<?php echo $textColor ?>"></span> <?php esc_html_e( 'Menu', 'nesctheme' ); ?> </button>
								<?php
									wp_nav_menu(
										array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
									)
									);
									?> 
								</nav><!-- #site-navigation --> 
						</div>  
					</div> 
					<div class="row">  
						<div class="col-sm-12">  

						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:<?php echo $textColor; ?>" rel="home"><?php bloginfo( 'name' ); ?> </a></h1>


						</div>  
					</div> 
				</div>
					
			
				
			
		</div><!-- .site-branding -->

		
	</header><!-- #masthead -->
