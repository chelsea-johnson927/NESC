<?php  
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0

 */

class Widget_link_image extends \Elementor\Widget_Base { 

    public function get_name() { 

        return 'link-image';
    }

	public function get_title() { 

        return esc_html__( 'link-image');
    }

	public function get_icon() { 

        return 'eicon-code';
    }

	

	public function get_categories() { 

        return [ 'general' ];
    }

	public function get_keywords() { 

        return [ 'link-image'];
    }



        protected function register_controls() {

            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__( 'Content', 'link-image' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
    
            $this->add_control(
                'title',
                [
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'label' => esc_html__( 'Image Text'),
                    'placeholder' => esc_html__( 'Title'),
                ]
            );
    
            
            $this->add_control(
                'image',
                [
                    'label' => esc_html__( 'Choose Image'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
            );
           
    
    
            $this->end_controls_section();
    
        }
    
    

	protected function render() { 
        $settings = $this->get_settings_for_display(); 


        // Get image URL
		$url =  $settings['image']['url'];

	
		// Get image HTML
		$this->add_render_attribute( 'div', 'src', $settings['image']['url'] );
		$this->add_render_attribute( 'div', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image'] ) );
		$this->add_render_attribute( 'div', 'title', \Elementor\Control_Media::get_image_title( $settings['image'] ) );
		$this->add_render_attribute( 'div', 'class', 'my-custom-class' );
		
	


       echo '<div class="image" style="background-image:url('.$url.')"><div class="cover"><h3 class="linkImage-widget-text">' . $settings['title'] . '</h3></div></div>';

    
    }
	protected function content_template() { 
?>
        <h3 class="{{ settings.title }}">{{{ settings.title }}}</h3>  

        <#
		if ( settings.image.url ) {
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			if ( ! image_url ) {
				return;
			}
		}
		#>
		
    <?php
    }

}



