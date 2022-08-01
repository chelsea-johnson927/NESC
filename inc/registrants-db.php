<?php 

add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here //loads scripts in admin footer 
add_action( 'wp_ajax_unregister', 'unregister_handler' );


//register Meta Box 

global $wpdb;  

//Check to see if table exists already if not, then create it 
$tables = array("registrants","waitlist"); 

foreach ($tables as $table) {
    
    $prefix =  $wpdb->prefix;
    $result= $prefix . $table;   

    if($wpdb->get_var("show tables like '$result'")!= $result){ 

        $sql = "CREATE TABLE ". $result . "("; 
        $sql .=" id int(11) NOT NULL AUTO_INCREMENT,"; 
        $sql .= "firstName varchar(255),";
        $sql .= "lastName varchar(255),"; 
        $sql .= "phoneNumber varchar(255),"; 
        $sql .= "email varchar(255),"; 
        $sql .= "eventID int(255),"; 
        $sql .= "PRIMARY KEY  (id)";
        $sql .= ")"; 
        require_once(ABSPATH . '/wp-admin/includes/upgrade.php'); 
        dbDelta($sql);
    }   

   
    
}
    
    function register_events_meta_box(){ 

        add_meta_box('1', esc_html__('Registrants And Waitlists', 'text-domain'), 'events_callback', 'events', 'advanced', 'high');   
        add_meta_box('2', esc_html__('Event Status', 'text-domain'), 'events_status_callback', 'events', 'advanced', 'high');  
        

    } 
    add_action('add_meta_boxes', 'register_events_meta_box'); 


//Add Field 

function events_callback(){ 
  
    global $wpdb;  
    $tables = array("registrants","waitlist");   
    $prefix =  $wpdb->prefix;
      

foreach ($tables as $table) {

    if(isset($_GET['post']) && !empty($_GET['post'])){ 

        $postID = $_GET['post']; 
        $result= $prefix . $table; 

    $query = 'SELECT * FROM ' . $result .  ' WHERE eventID = ' . $postID . ';'; 
    $results = $wpdb->get_results($query);  

    echo '<h2 class"table-name">' . $result . '</h2>'; 

    if($result == "wp_registrants"){ 

        $bttn = "unregister"; 
    }else{ 

        $bttn = "register"; 
    }

    echo '<table class="' . $result .'"> 
            <tr> 
            <th>First Name</th> 
            <th>Last Name</th>  
            <th>Phone Number</th>  
            <th>Email</th>  
            <tr>'; 

            foreach($results as $row){ 

                echo '<tr><td>'.$row->firstName . '</tb><td> 
                <td>'.$row->lastName . '</tb> 
                <td>'. $row->phoneNumber . '</tb> 
                <td>'. $row->email . '</td> 
                <td> <button type="button"  data-id="'.$row->id.'" name="'. $bttn .'" value="'.$bttn.'" style="cursor:pointer;">'. $bttn . '</button></td></tr>';    
               


            } 

            echo '</table>';   

} 

}

} 

function events_status_callback(){  


   if(isset($_GET['post']) && !empty($_GET['post'])){ 

    $postID = $_GET['post'];   
    $regTable = "wp_registrants";     
    $query = 'SELECT COUNT(*) FROM'. $regTable . ' WHERE eventID ='. $postID . ';'; 


    $rowcount = $wpdb->get_var($query);

    
    
    
    $rowcount;






   
    echo '<h2 class"event-status">' . $results . '</h2>'; 


   }



}















  
function my_action_javascript() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($){ 

        $(".wp_registrants button").on("click", function(){ 

            var dataID = $(this).attr("data-id"); 

            var data = {
			'action': 'unregister',
			'ID': dataID
		};

jQuery.post(ajaxurl, data, function(response) {
			
        alert("User has been unregistered!"); 


        }); 



		
	});   
});  

	</script> <?php  }
    


    function  unregister_handler() {
        
        global $wpdb;  
        $table_name = $wpdb->prefix."registrants"; 
        $ID = $_POST["ID"]; 
	    $wpdb->delete( $table_name, array( 'id' => $ID ) );

    
        wp_die(); // this is required to terminate immediately and return a proper response
    }



?>