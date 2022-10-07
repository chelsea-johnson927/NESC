<?php 

add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here //loads scripts in admin footer 
add_action( 'wp_ajax_unregister', 'unregister_handler' );
add_action( 'wp_ajax_addToRegistration', 'addToRegistration_handler' );

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
            <th>Button</th>
            </tr>'; 

            foreach($results as $row){ 

                echo '<tr><td id="fname">'.$row->firstName . '</tb>
                <td id="lname">'.$row->lastName . '</tb> 
                <td id="phone">'. $row->phoneNumber . '</tb> 
                <td id="email">'. $row->email . '</td> 
                <td> <button type="button"  data-id="'.$row->id.'" name="'. $bttn .'" value="'.$bttn.'" style="cursor:pointer;">'. $bttn . '</button></td></tr>';    
               


            } 

            echo '</table> 
            
            <input type="hidden" id="event-ID" name="event-ID" value="'. $postID .'">';    

} 

}

 
}  


function events_status_callback(){  


    global $wpdb;   

   if(isset($_GET['post']) && !empty($_GET['post'])){ 

    $postID = $_GET['post'];    
    $prefix =  $wpdb->prefix; 
    $table = "registrants";   
    $result= $prefix . $table;    
    $query = 'SELECT COUNT(*) FROM '. $result . ' WHERE eventID = '. $postID . ';';  
    $rowcount = $wpdb->get_var($query);
    $maxReg = get_post_meta( $postID, 'max_registrants', true ); 
    $spotsLeft = (int)$maxReg - (int)$rowcount; 

    if($spotsLeft == 0){ 

        $meta_value = 'Full';  
        echo '<h2 id="event-status">' . $meta_value . '</h2>'; 

        update_post_meta( $postID, 'event_status', $meta_value); 

    }elseif($spotsLeft >=1 && $spotsLeft <=5){ 

        $meta_value = 'Almost Full';  
        echo '<h2 id="event-status">' . $meta_value . '</h2>'; 

        update_post_meta( $postID, 'event_status', $meta_value);  
        update_post_meta( $postID, 'spots_left', $spotsLeft); 

    }else{ 

        $meta_value = 'Open';  
        echo '<h2 id="event-status">' . $meta_value . '</h2>'; 

        update_post_meta( $postID, 'event_status', $meta_value);  
        
    }
   

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
    

        $(".wp_waitlist button").on("click", function(){ 

            
            
           
            var dataID = $(this).attr("data-id");   
            var eventID = document.getElementById("event-ID").value;
          

                var data = {
                'action': 'addToRegistration', 
                'ID': dataID, 
                'eventID': eventID
                };

                jQuery.post(ajaxurl, data, function(response) {

                    console.log(response); 
                
                    alert(response); 


            }); 
	
	});     

});   

	</script> <?php  }


    function  addToRegistration_handler() {
        
       
         global $wpdb;  
        $table_wait = $wpdb->prefix."waitlist";  
        $table_reg = $wpdb->prefix."registrants"; 
        $dataID = $_POST["ID"];   
        $eventID = $_POST['eventID']; 
        
        
        $maxReg = get_post_meta( $eventID, 'max_registrants', true ); 
        
        
        $query = 'SELECT COUNT(*) FROM '. $table_reg . ' WHERE eventID = '. $eventID . ';';  
        $rowcount = $wpdb->get_var($query);  

        $spotsLeft = (int)$maxReg - (int)$rowcount; 

        if($spotsLeft == 0){ 

            $message = "event has reached maximum number of registrants. User cannot be added."; 

            

        }else{  


            $data = 'SELECT * FROM ' . $table_wait. ' WHERE id = ' . $dataID . ';'; 
            $result = $wpdb->get_results($data);  
             
            foreach($result as $row){    

                $insert = $wpdb->insert( 
                    $table_reg, 
                    array( 
                        'FirstName' => $row->firstName, 
                        'LastName' => $row->lastName, 
                        'phoneNumber' => $row->phoneNumber, 
                        'email' => $row->email,  
                        'eventID' => $eventID 
            
                    )   
                    ); 

                    if($insert){

                        $wpdb->delete( $table_wait, array( 'id' => $dataID ) );
                      
            
                        }else{ 
            
            
                        } 
            
            } 

            $message = "User has been added to registration.";  
          
          

           

        } 

   
        echo json_encode($message);
        wp_die(); // this is required to terminate immediately and return a proper response
   
    }
        
    
    


    function  unregister_handler() {
        
        global $wpdb;  
        $table_name = $wpdb->prefix."registrants"; 
        $ID = $_POST["ID"]; 
	    $wpdb->delete( $table_name, array( 'id' => $ID ) );

    
        wp_die(); // this is required to terminate immediately and return a proper response
    }



?>