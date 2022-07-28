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

class Widget_calendar extends \Elementor\Widget_Base { 

    public function get_name() { 

        return 'calendar';
    }

	public function get_title() { 

        return esc_html__( 'calendar');
    }

	public function get_icon() { 

        return 'eicon-code';
    }

	

	public function get_categories() { 

        return [ 'general' ];
    }

	public function get_keywords() { 

        return [ 'calendar'];
    }



        protected function register_controls() {

            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__( 'Content', 'link-image' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
    
          
    
    
            $this->end_controls_section();
    
        }
    
    

	protected function render() { 
       
        echo '<div id="calendar"></div>';
    }
	protected function content_template() { 

       
    }

}




















































